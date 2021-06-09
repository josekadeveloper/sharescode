<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "likes".
 *
 * @property int $id
 * @property string $nickname
 * @property int|null $answer_id
 * @property int|null $users_id
 *
 * @property Users $users
 */
class Likes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'likes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nickname'], 'required'],
            [['answer_id', 'users_id'], 'default', 'value' => null],
            [['answer_id', 'users_id'], 'integer'],
            [['nickname'], 'string', 'max' => 255],
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
            'nickname' => 'Nickname',
            'answer_id' => 'Answer ID',
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
        return $this->hasOne(Users::class, ['id' => 'users_id'])->inverseOf('likes');
    }
}
