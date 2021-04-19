<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notRegistered".
 *
 * @property int $id
 * @property string|null $created_at
 * @property string|null $token
 *
 * @property Portrait $id0
 */
class NotRegistered extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notRegistered';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'default', 'value' => null],
            [['id'], 'integer'],
            [['created_at'], 'safe'],
            [['token'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Portrait::class, 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'token' => 'Token',
        ];
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPortrait()
    {
        return $this->hasOne(Portrait::class, ['id' => 'id'])->inverseOf('notRegistered');
    }
}
