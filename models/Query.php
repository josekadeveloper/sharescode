<?php

namespace app\models;

use DateTime;
use DateTimeZone;
use Yii;

/**
 * This is the model class for table "query".
 *
 * @property int $id
 * @property string $title
 * @property string $explanation
 * @property string $date_created
 * @property bool|null $is_closed
 * @property int|null $users_id
 *
 * @property Answer[] $answers
 */
class Query extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'explanation', 'date_created'], 'required'],
            [['explanation'], 'string'],
            [['date_created'], 'safe'],
            [['is_closed'], 'boolean'],
            [['users_id'], 'default', 'value' => null],
            [['users_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Portrait::class, 'targetAttribute' => ['users_id' => 'id']],
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
            'explanation' => 'Explanation',
            'date_created' => 'Date Created',
            'is_closed' => 'Is Closed',
            'users_id' => 'User',
        ];
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        if (!Yii::$app->user->identity->is_admin === true) {
            if ($this->getAnswers()->exists()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Gets query for [[Answers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::class, ['query_id' => 'id'])->inverseOf('query');
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'users_id'])->inverseOf('queries');
    }

    public function getLastAnswer()
    {
        $last_date = $this->getAnswers()->max('date_created');
        return Answer::findOne(['date_created' => $last_date])['content'] === null ? '' 
                : Answer::findOne(['date_created' => $last_date])['content'];
    }
    
    /**
     * Find the name of the user from the id of the query.
     * @param integer $id
     * @return mixed String || null
     */
    public static function findUserName($id)
    {
        if (($model = Query::find()
                    ->where(['id' => $id])
                    ->one()) !== null
            ){
            $user_id = $model->users_id;
            $model_user = Portrait::findOne(['id' => $user_id]);
            $username = $model_user->nickname;
            return $username;
        }
        return null;
    }

    /**
     * Find the image of the user from the id of the query.
     * @param integer $id
     * @return mixed Image || null
     */
    public static function findUserImage($id)
    {
        if (($model = Query::find()
                    ->where(['id' => $id])
                    ->one()) !== null
            ){
            $user_id = $model->users_id;
            $model_user = Portrait::findOne(['id' => $user_id]);
            $img = $model_user->devolverImg($model_user);
            return $img;
        }
        return null;
    }

    /**
     * Find the title of the query from the id of the query.
     * @param integer $id
     * @return mixed String || null
     */
    public static function findTitleQuery($id)
    {
        return Query::findOne(['id' => $id])['title'];
    }

    /**
     * Formats UTC dateTime to Europe dateTime
     * @param object DateTime
     * @return mixed string
     */
    public static function formatDate($dt)
    {
        $date_created = date($dt);
        $dt = new DateTime($date_created);
        $dt->setTimezone(new DateTimeZone('Europe/Madrid'));
        $dt = $dt->format('d-m-Y H:i:s');

        return $dt;
    }
}
