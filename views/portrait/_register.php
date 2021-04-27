<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
$sex = ['Men' => 'Men',
        'Woman' => 'Woman'];
?>
<div class="users-form todo-padding">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true])->label('Password') ?>
        
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('Password Repeat')  ?>

    <?= $form->field($model, 'date_register')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'repository')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prestige_port')->hiddenInput(['maxlength' => true, 'value' => 'Initiate'])->label(false) ?>

    <?= $form->field($model, 'sex')->textInput(['maxlength' => true])->dropDownList($sex)  ?>

        <div class="form-group">
            <?= Html::submitButton('Register', ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>