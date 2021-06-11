<?php

namespace app\models;

use yii\base\Model;

class EmailRecoveryForm extends Model
{
    /**
     * User email to restore their password.
     * @var string
     */
    public $email;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => Portrait::className(),
                'message' => 'There is no registered user with this email.',
            ],
        ];
    }
}