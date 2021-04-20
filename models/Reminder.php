<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reminder".
 *
 * @property int $id
 * @property string $dispatch
 * @property int|null $users_id
 *
 * @property Users $users
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
            [['dispatch'], 'required'],
            [['users_id'], 'default', 'value' => null],
            [['users_id'], 'integer'],
            [['dispatch'], 'string', 'max' => 255],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['users_id' => 'id']],
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
            'users_id' => 'Users ID',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::class, ['id' => 'users_id'])->inverseOf('reminders');
    }
}
