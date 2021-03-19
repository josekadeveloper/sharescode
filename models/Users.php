<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $nickname
 * @property string $password
 * @property bool $is_admin
 *
 * @property Answer[] $answers
 * @property Portrait[] $portraits
 * @property Query[] $queries
 * @property Reminder[] $reminders
 */
class Users extends \yii\db\ActiveRecord implements IdentityInterface
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_REGISTER = 'register';

    public $password_repeat;
    public $reCaptcha;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nickname', 'password'], 'required'],
            [['is_admin'], 'boolean'],
            [['nickname', 'password'], 'string', 'max' => 255],
            [['nickname'], 'unique'],
            [['password', 'password_repeat'], 'required', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_REGISTER]],
            [['password'], 'compare', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE, self::SCENARIO_REGISTER]],
            [['password_repeat'], 'safe', 'on' => [self::SCENARIO_UPDATE, self::SCENARIO_REGISTER]],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['password_repeat']);
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nickname' => 'Nickname',
            'password' => 'Password',
            'is_admin' => 'Is Admin',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert) {
            if ($this->scenario === self::SCENARIO_CREATE || self::SCENARIO_REGISTER) {
                goto salto;
            }
        } else {
            if ($this->scenario === self::SCENARIO_UPDATE) {
                if ($this->password === '') {
                    $this->password = $this->getOldAttribute('password');
                } else {
                    salto:
                    $this->password = Yii::$app->security
                        ->generatePasswordHash($this->password);
                }
            }
        }
        return true;
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        if ($this->getPortrait()->exists()) {
            return false;
        }

        return true;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    public function getAuthKey()
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function validateAuthKey($authKey)
    {
    }

    public static function findByNickName($nickname)
    {
        return static::findOne(['nickname' => $nickname]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security
            ->validatePassword($password, $this->password);
    }

    /**
     * Gets query for [[Answers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::class, ['us_id' => 'id']);
    }

    /**
     * Gets query for [[Portraits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPortrait()
    {
        return $this->hasOne(Portrait::class, ['us_id' => 'id'])
                    ->inverseOf('users');
    }

    /**
     * Gets query for [[Queries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQueries()
    {
        return $this->hasMany(Query::class, ['us_id' => 'id']);
    }

    /**
     * Gets query for [[Reminders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReminders()
    {
        return $this->hasMany(Reminder::class, ['us_id' => 'id']);
    }
}