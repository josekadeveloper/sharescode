<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reminder".
 *
 * @property int $id
 * @property string $title
 * @property string $dispatch
 * @property string $date_created
 * @property boolean $is_read
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
            [['title', 'dispatch', 'users_id'], 'required'],
            [['date_created'], 'safe'],
            [['users_id'], 'integer'],
            [['title', 'dispatch'], 'string', 'max' => 255],
            [['is_read'], 'boolean'],
            [['is_read'], 'default', 'value' => false],
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
            'title' => 'Title',
            'dispatch' => 'Dispatch',
            'date_created' => 'Date Created',
            'is_read' => 'Is Read',
            'users_id' => 'Transmitter User',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'users_id'])->inverseOf('reminders');
    }

    /**
     * Gets query for [[Portrait]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNickname()
    {
        return Portrait::findOne(['id' => $this->users_id])['nickname'];
    }

    /**
     *  Check that the notification is correct
     * to proceed to delete it
     * @param integer $answer_id
     * @return mixed string || null
     */
    public static function checkReminder($answer_id)
    {
        $date_created = Answer::findOne(['id' => $answer_id])['date_created'];
        $users_id = Answer::checkAnswer($answer_id);
    
        return Reminder::findOne([
            'date_created' => $date_created,
            'users_id' => $users_id,
        ])['id'];
    }
}
