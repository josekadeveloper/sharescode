<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property bool $is_deleted
 * 
 * @property Portrait[] $portraits
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_deleted'], 'boolean'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['password_repeat']);
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_deleted' => 'Is Deleted',
        ];
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        if ($this->getPortrait()->exists()) {
            Yii::$app->session->setFlash('error', 'User is associated with some portrait.');
            return false;
        }

        return true;
    }

    /**
     * Gets query for [[Portraits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPortrait()
    {
        return $this->hasOne(Portrait::class, ['us_id' => 'id'])
                    ->inverseOf('users');
    }
}