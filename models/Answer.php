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
            [['likes', 'dislikes', 'query_id', 'users_id'], 'default', 'value' => null],
            [['likes', 'dislikes', 'query_id', 'users_id'], 'integer'],
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
            'likes' => 'Likes',
            'dislikes' => 'Dislikes',
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
        if ((Portrait::findOne(['id' => $users_id])) !== null) {
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
        if ((Portrait::findOne(['id' => $users_id])) !== null) {
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
        if ((Portrait::findOne(['id' => $users_id])) !== null) {
            $urlPortrait = Url::to(['portrait/view', 'id' => $users_id]);
            return $urlPortrait;
        }
        return null;
    }

    /**
     *  Check the best-scored answer
     * @param integer $query_id, $answer_id
     * @return mixed boolean || null
     */
    public static function bestAnswer($query_id, $answer_id)
    {
        $otherAnswer = Answer::findOne(['id' => $answer_id]);
        $theBest = Answer::find()->where(['query_id' => $query_id])->max('likes');
        $theWorst = Answer::find()->where(['query_id' => $query_id])->max('dislikes');
        $dateTime = Answer::find()->where(['query_id' => $query_id])->min('date_created');

        if ($theBest === 0) {
            return null;
        }
        if ($otherAnswer->likes === $theBest) {
            if ($theWorst === 0) {
                if ($otherAnswer->date_created === $dateTime) {
                    return true;
                }
            } else {
                if ($otherAnswer->dislikes !== $theWorst) {
                    return true;
                } else {
                    return false;
                }
            }
        }
        return false;
    }
}
