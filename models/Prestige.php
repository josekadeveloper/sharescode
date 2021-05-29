<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prestige".
 *
 * @property int $id
 * @property string $type_prestige
 * @property int $score
 *
 * @property Portrait $portrait
 */
class Prestige extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prestige';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_prestige'], 'required'],
            [['score'], 'default', 'value' => null],
            [['score'], 'integer'],
            [['type_prestige'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_prestige' => 'Type Prestige',
            'score' => 'Score',
        ];
    }
}
