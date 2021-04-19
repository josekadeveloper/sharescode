<?php

namespace app\models;

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
}
