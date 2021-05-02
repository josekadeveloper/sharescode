<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "answer".
 *
 * @property int $id
 * @property string $content
 * @property string $date_created
 * @property int $query_id
 * @property int|null $users_id
 *
 * @property Users $users
 * @property Query $query
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'date_created', 'query_id'], 'required'],
            [['date_created'], 'safe'],
            [['query_id', 'users_id'], 'default', 'value' => null],
            [['query_id', 'users_id'], 'integer'],
            [['content'], 'string', 'max' => 255],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['users_id' => 'id']],
            [['query_id'], 'exist', 'skipOnError' => true, 'targetClass' => Query::class, 'targetAttribute' => ['query_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'date_created' => 'Date Created',
            'query_id' => 'Query ID',
            'users_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[Portrait]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'users_id'])->inverseOf('answers');
    }

    /**
     * Gets query for [[Query]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuery()
    {
        return $this->hasOne(Query::class, ['id' => 'query_id'])->inverseOf('answers');
    }

    /**
     * Find the name of the user from the users_id of the answer.
     * @param integer $users_id
     * @return mixed String || null
     */
    public static function findUserName($users_id)
    {
        if ((Portrait::findOne(['id' => $users_id])) !== null){
            $model_user = Portrait::findOne(['id' => $users_id]);
            $username = $model_user->nickname;
            return $username;
        }
        return null;
    }

    /**
     * Find the image of the user from the id of the answer.
     * @param integer $id
     * @return mixed Image || null
     */
    public static function findUserImage($users_id)
    {
        if ((Portrait::findOne(['id' => $users_id])) !== null){
            $model_user = Portrait::findOne(['id' => $users_id]);
            $img = $model_user->devolverImg($model_user);
            return $img;
        }
        return null;
    }

    /**
     * Find the name of the user from the id of the answer.
     * @param integer $id
     * @return mixed URL || null
     */
    public static function findUserPortrait($users_id)
    {
        if ((Portrait::findOne(['id' => $users_id])) !== null){
            $urlPortrait = Url::to(['portrait/view', 'id' => $users_id]);
            return $urlPortrait;
        }
        return null;
    }
}
