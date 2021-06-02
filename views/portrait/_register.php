<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->registerCssFile('@web/assets/checkPassword/password-strength.css', ['position' => $this::POS_HEAD]);
$this->registerJsFile('@web/assets/checkPassword/password-strength.js', ['position' => $this::POS_END]);

$checkPassword = <<<EOT
$('#portrait-password_repeat').keyup(function(event) {
    var password = $('#portrait-password_repeat').val();
    checkPasswordStrength(password);
  });
EOT;
$this->registerJs($checkPassword);

$sex = ['Men' => 'Men',
        'Woman' => 'Woman'];
?>
<div class="row justify-content-center">
    <div class="users-form formulario col-md-4">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true])->label('Password') ?>
            
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('Password Repeat')  ?>

        <?= $form->field($model, 'date_register')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'repository')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'prestige_port')->hiddenInput(['maxlength' => true, 'value' => 'Initiate'])->label(false) ?>

        <?= $form->field($model, 'sex')->textInput(['maxlength' => true])->dropDownList($sex)  ?>
        
        <hr>
        <ul class="pswd_info" id="passwordCriterion">
            <li data-criterion="length" class="invalid">8-15 <strong>Characters</strong></li>
            <li data-criterion="capital" class="invalid">At least <strong>one capital letter</strong></li>
            <li data-criterion="small" class="invalid">At least <strong>one small letter</strong></li>
            <li data-criterion="number" class="invalid">At least <strong>one number</strong></li>
            <li data-criterion="special" class="invalid">At least <strong>one Specail Characters </strong></li>
        </ul>
        <div id="password-strength-status"></div>
        <hr>

        <div class="form-group">
            <?= Html::submitButton('Register', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>