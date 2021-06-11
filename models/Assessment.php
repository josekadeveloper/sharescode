<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "assessment".
 *
 * @property int $id
 * @property string $total_percent
 * @property int $votes_id
 *
 * @property Votes $votes
 */
class Assessment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assessment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['votes_id'], 'required'],
            [['votes_id'], 'default', 'value' => null],
            [['votes_id'], 'integer'],
            [['total_percent'], 'number'],
            [['votes_id'], 'exist', 'skipOnError' => true, 'targetClass' => Votes::class, 'targetAttribute' => ['votes_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'total_percent' => 'Total Percent',
            'votes_id' => 'Votes ID',
        ];
    }

    /**
     * Gets query for [[Votes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVotes()
    {
        return $this->hasOne(Votes::class, ['id' => 'votes_id'])->inverseOf('assessments');
    }
}
