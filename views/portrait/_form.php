<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$urlNickname = Url::to(['portrait/looking-for-nickname-ajax']);
$urlEmail = Url::to(['portrait/looking-for-email-ajax']);
$urlRepository = Url::to(['portrait/looking-for-repository-ajax']);

$validation = <<<EOT
    $('#portrait-nickname').blur(function (ev) {
        var nickname = $(this).val();

        $.ajax({
            type: 'GET',
            url: '$urlNickname',
            data: {
                nickname: nickname
            }
        })
        .done(function (data) {
            if (data.find) {
                $('#nickname').show();
                $('#nickname').html('Error: nickname is already in use');
                $('#nickname').addClass('text-danger');
                /*$('#portrait-nickname').removeClass('form-control is-valid');
                $('#portrait-nickname').addClass('form-control is-invalid');*/
            } else {
                $('#nickname').html(data.nickname);
                $('#nickname').hide();
                /*$('#portrait-nickname').removeClass('form-control is-invalid');
                $('#portrait-nickname').addClass('form-control is-valid');*/
            }
        });
    });

    $('#portrait-email').blur(function (ev) {
        var email = $(this).val();

        $.ajax({
            type: 'GET',
            url: '$urlEmail',
            data: {
                email: email
            }
        })
        .done(function (data) {
            if (data.find) {
                $('#email').show();
                $('#email').html('Error: email is already in use');
                $('#email').addClass('text-danger');
            } else {
                $('#email').html(data.email);
                $('#email').hide();
            }
        });
    });

    $('#portrait-repository').blur(function (ev) {
        var repository = $(this).val();

        $.ajax({
            type: 'GET',
            url: '$urlRepository',
            data: {
                repository: repository
            }
        })
        .done(function (data) {
            if (data.find) {
                $('#repository').show();
                $('#repository').html('Error: repository is already in use');
                $('#repository').addClass('text-danger');
            } else {
                $('#repository').html(data.repository);
                $('#repository').hide();
            }
        });
    });
EOT;
$this->registerJs($validation);

$sex = ['Men' => 'Men',
        'Woman' => 'Woman'];
?>
<div class="row justify-content-center">
    <div class="portrait-form formulario col-md-4" style="margin-bottom: 5vw;">

        <?php $form = ActiveForm::begin(); ?>

            <?php if (Yii::$app->user->identity->is_admin === true): ?>
                <?= $form->field($model, 'is_admin')->checkbox() ?>
            <?php endif ?>

            <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>

            <?= Html::label('', '', [
                'id' => 'nickname',
            ]) ?>

            <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true])->label('Password') ?>
                
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('Password Repeat')  ?>

            <?= $form->field($model, 'date_register')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false) ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            
            <?= Html::label('', '', [
                'id' => 'email',
            ]) ?>

            <?= $form->field($model, 'repository')->textInput(['maxlength' => true]) ?>

            <?= Html::label('', '', [
                'id' => 'repository',
            ]) ?>

            <?= $form->field($model, 'prestige_port')->hiddenInput(['maxlength' => true, 'value' => 'Initiate'])->label(false) ?>

            <?= $form->field($model, 'sex')->textInput(['maxlength' => true])->dropDownList($sex)  ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
