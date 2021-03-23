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
 * @property int|null $portrait_id
 *
 * @property Answer[] $answers
 * @property Portrait $portrait
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
            [['portrait_id'], 'default', 'value' => null],
            [['portrait_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['portrait_id'], 'exist', 'skipOnError' => true, 'targetClass' => Portrait::class, 'targetAttribute' => ['portrait_id' => 'id']],
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
            'portrait_id' => 'Portrait',
        ];
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        if ($this->getAnswers()->exists()) {
            return false;
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
     * Gets query for [[Portrait]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPortrait()
    {
        return $this->hasOne(Portrait::class, ['id' => 'portrait_id'])->inverseOf('queries');
    }
}
