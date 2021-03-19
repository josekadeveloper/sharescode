<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $nickname
 * @property string $password
 * @property bool $is_admin
 *
 * @property Portrait[] $portraits
 * @property Reminder[] $reminders
 */
class Users extends \yii\db\ActiveRecord
{
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
        ];
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

    /**
     * Gets query for [[Portraits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPortraits()
    {
        return $this->hasMany(Portrait::class, ['us_id' => 'id'])->inverseOf('us');
    }

    /**
     * Gets query for [[Reminders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReminders()
    {
        return $this->hasMany(Reminder::class, ['us_id' => 'id'])->inverseOf('us');
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> master
