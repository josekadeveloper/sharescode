<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reminder".
 *
 * @property int $id
 * @property string $dispatch
 * @property int $us_id
 *
 * @property Users $us
 */
class Reminder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reminder';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dispatch', 'us_id'], 'required'],
            [['us_id'], 'default', 'value' => null],
            [['us_id'], 'integer'],
            [['dispatch'], 'string', 'max' => 255],
            [['us_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['us_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dispatch' => 'Dispatch',
            'us_id' => 'Us ID',
        ];
    }

    /**
     * Gets query for [[Us]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUs()
    {
        return $this->hasOne(Users::className(), ['id' => 'us_id'])->inverseOf('reminders');
    }
}
