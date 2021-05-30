<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "type_prestige".
 *
 * @property int $id
 * @property string $prestige
 * @property int $score
 *
 * @property Prestige[] $prestiges
 */
class TypePrestige extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'type_prestige';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prestige', 'score'], 'required'],
            [['score'], 'default', 'value' => null],
            [['score'], 'integer'],
            [['prestige'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prestige' => 'Prestige',
            'score' => 'Score',
        ];
    }

    /**
     * Gets query for [[Prestiges]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrestiges()
    {
        return $this->hasMany(Prestige::class, ['type_prestige_id' => 'id'])->inverseOf('typePrestige');
    }
}
