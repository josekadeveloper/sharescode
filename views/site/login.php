<?php
use yii\helpers\Html;
use yii\helpers\Url;

$url_register = Url::to(['/portrait/register']);
$url_recovery = Url::to(['/portrait/recovery-pass']);
?>
<div class="row justify-content-center">
    <div class="card col-md-6 login">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'login-form']) ?>

            <?= $form->field($model,'username', [
                'options' => ['class' => 'form-group has-feedback'],
                'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>',
                'template' => '{beginWrapper}{input}{error}{endWrapper}',
                'wrapperOptions' => ['class' => 'input-group mb-3']
            ])
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

            <?= $form->field($model, 'password', [
                'options' => ['class' => 'form-group has-feedback'],
                'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
                'template' => '{beginWrapper}{input}{error}{endWrapper}',
                'wrapperOptions' => ['class' => 'input-group mb-3']
            ])
                ->label(false)
                ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

            <div class="row">
                <div class="col-8">
                </div>
                <div class="col-4">
                    <?= Html::submitButton('Sign In', ['class' => 'btn btn-primary btn-block']) ?>
                </div>
            </div>

            <?php \yii\bootstrap4\ActiveForm::end(); ?>

            <p class="mb-1">
                <a href="<?= $url_recovery ?>">I forgot my password</a>
            </p>
            <p class="mb-0">
                <a href="<?= $url_register ?>" class="text-center">Register a new membership</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>

