<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "answer".
 *
 * @property int $id
 * @property string $content
 * @property int $query_id
 * @property int $us_id
 *
 * @property Query $query
 * @property Users $us
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
            [['content', 'query_id', 'us_id'], 'required'],
            [['query_id', 'us_id'], 'default', 'value' => null],
            [['query_id', 'us_id'], 'integer'],
            [['content'], 'string', 'max' => 255],
            [['query_id'], 'exist', 'skipOnError' => true, 'targetClass' => Query::class, 'targetAttribute' => ['query_id' => 'id']],
            [['us_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['us_id' => 'id']],
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
            'query_id' => 'Query',
            'us_id' => 'Us',
        ];
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
     * Gets query for [[Us]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUs()
    {
        return $this->hasOne(Users::class, ['id' => 'us_id'])->inverseOf('answers');
    }
}
