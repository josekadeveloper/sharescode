<?php

namespace app\models;

use Yii;
use yii\bootstrap4\Html;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "portrait".
 *
 * @property int $id
 * @property bool $is_admin
 * @property string $nickname
 * @property string $password
 * @property string $date_register
 * @property string $email
 * @property string $repository
 * @property string $prestige_port
 * @property string $sex
 * @property string|null $token_pass
 *
 * @property Users $us
 */
class Portrait extends \yii\db\ActiveRecord implements IdentityInterface
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_REGISTER = 'register';
    const SCENARIO_RECOVERY = 'recovery';

    public $password_repeat;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'portrait';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_admin'], 'boolean'],
            [['nickname', 'password', 'date_register', 'email', 'repository', 'sex'], 'required'],
            [['date_register'], 'safe'],
            [['nickname', 'password', 'email', 'repository', 'prestige_port', 'token_pass'], 'string', 'max' => 255],
            [['sex'], 'string'],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['nickname'], 'unique'],
            [['repository'], 'unique'],
            [['token_pass'], 'unique'],
            [['password', 'password_repeat'], 'required', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_REGISTER, self::SCENARIO_RECOVERY]],
            [['password'], 'compare', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE, self::SCENARIO_REGISTER, self::SCENARIO_RECOVERY]],
            [['password_repeat'], 'safe', 'on' => [self::SCENARIO_UPDATE, self::SCENARIO_REGISTER, self::SCENARIO_RECOVERY]],
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
            'is_admin' => 'Is Admin',
            'nickname' => 'Nickname',
            'password' => 'Password',
            'date_register' => 'Date Register',
            'email' => 'Email',
            'repository' => 'Repository',
            'prestige_port' => 'Prestige Port',
            'sex' => 'Sex',
            'token_pass' => 'Token Pass',
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
            if ($this->scenario === self::SCENARIO_UPDATE || 
                $this->scenario === self::SCENARIO_RECOVERY) {
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

    public static function devolverImg($model) {
        $sexo = $model->sex;
        if ($sexo !== null) {
            if ($sexo === 'Men') {
                $img = Html::img('@web/img/men.svg');
            } else {
                $img = Html::img('@web/img/woman.svg');
            }
        };
        return $img;
    }

    public function validateActivation()
    {
        return $this->notRegistered === null;
    }

    public function getNotRegistered()
    {
        return $this->hasOne(NotRegistered::class, ['id' => 'id'])
            ->inverseOf('portrait');
    }

    /**
     * Gets query for [[Us]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUs()
    {
        return $this->hasOne(Users::class, ['id' => 'id'])->inverseOf('portraits');
    }
}
