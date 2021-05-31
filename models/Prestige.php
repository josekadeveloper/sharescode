<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prestige".
 *
 * @property int $id
 * @property string $title
 * @property string|null $antiquity
 * @property int $puntuation
 * @property int|null $type_prestige_id
 * @property int|null $users_id
 *
 * @property TypePrestige $typePrestige
 * @property Users $users
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
            [['antiquity'], 'safe'],
            [['puntuation', 'type_prestige_id', 'users_id'], 'default', 'value' => null],
            [['puntuation', 'type_prestige_id', 'users_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['type_prestige_id'], 'exist', 'skipOnError' => true, 'targetClass' => TypePrestige::class, 'targetAttribute' => ['type_prestige_id' => 'id']],
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
            'title' => 'Title',
            'antiquity' => 'Antiquity',
            'puntuation' => 'Puntuation',
            'type_prestige_id' => 'Type',
            'users_id' => 'User',
        ];
    }

    /**
     * Gets query for [[TypePrestige]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTypePrestige()
    {
        return $this->hasOne(TypePrestige::class, ['id' => 'type_prestige_id'])->inverseOf('prestiges');
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::class, ['id' => 'users_id'])->inverseOf('prestiges');
    }
}
