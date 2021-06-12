<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "votes".
 *
 * @property int $id
 * @property string $typ
 * @property int $puntuation
 * @property int $users_id
 *
 * @property Assessment[] $assessments
 * @property Users $users
 */
class Votes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'votes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['typ', 'puntuation', 'users_id'], 'required'],
            [['puntuation', 'users_id'], 'default', 'value' => null],
            [['puntuation', 'users_id'], 'integer'],
            [['typ', 'suggesting'], 'string', 'max' => 255],
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
            'typ' => 'Typ',
            'puntuation' => 'Puntuation',
            'suggesting' => 'Suggesting',
            'users_id' => 'Users ID',
        ];
    }

    /**
     * Gets query for [[Assessments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssessments()
    {
        return $this->hasMany(Assessment::class, ['votes_id' => 'id'])->inverseOf('votes');
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::class, ['id' => 'users_id'])->inverseOf('votes');
    }
}
