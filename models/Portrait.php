<?php

namespace app\models;

use Yii;
use yii\bootstrap4\Html;

/**
 * This is the model class for table "portrait".
 *
 * @property int $id
 * @property string $name_portrait
 * @property string $last_name
 * @property string $date_register
 * @property string $email
 * @property string $repository
 * @property string $prestige_port
 * @property string $sex
 * @property int $us_id
 *
 * @property Users $us
 * @property Prestige[] $prestiges
 * @property Query[] $queries
 */
class Portrait extends \yii\db\ActiveRecord
{
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
            [['name_portrait', 'last_name', 'date_register', 'email', 'repository', 'sex', 'us_id'], 'required'],
            [['date_register'], 'safe'],
            [['us_id'], 'default', 'value' => null],
            [['us_id'], 'integer'],
            [['name_portrait', 'last_name', 'email', 'repository', 'prestige_port'], 'string', 'max' => 255],
            [['sex'], 'string'],
            [['email'], 'unique'],
            [['name_portrait'], 'unique'],
            [['repository'], 'unique'],
            [['us_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['us_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_portrait' => 'Name Portrait',
            'last_name' => 'Last Name',
            'date_register' => 'Date Register',
            'email' => 'Email',
            'repository' => 'Repository',
            'prestige_port' => 'Prestige Port',
            'sex' => 'Sex',
            'us_id' => 'User',
        ];
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        if ($this->getQueries()->exists()) {
            Yii::$app->session->setFlash('error', 'User is associated with some queries.');
            return false;
        }

        return true;
    }

    public function devolverImg($model) {
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

    /**
     * Gets query for [[Us]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUs()
    {
        return $this->hasOne(Users::class, ['id' => 'us_id'])->inverseOf('portraits');
    }

    /**
     * Gets query for [[Prestiges]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrestiges()
    {
        return $this->hasMany(Prestige::class, ['portrait_id' => 'id'])->inverseOf('portrait');
    }

    /**
     * Gets query for [[Queries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQueries()
    {
        return $this->hasMany(Query::class, ['portrait_id' => 'id'])->inverseOf('portrait');
    }
}
