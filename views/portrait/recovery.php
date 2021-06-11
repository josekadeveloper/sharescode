
<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;

$this->title = 'Modify Password';
?>
<div class="portrait formulario">
    <div class="float-right col-md-3">
        <?= Html::a('Return to Login', ['site/login'], ['class' => 'btn btn-info'])?>
    </div>
    <div class="col-md-9">
        <h3><strong><?= Html::encode($this->title) ?></strong></h3>
        <hr>
        <div class="col-md-offset-3 col-md-12">
            <div class="row justify-content-center">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'password')
                ->passwordInput(['maxlength' => true, 'placeholder' => 'New password'])
                ->label(false) ?>

                <?= $form->field($model, 'password_repeat')
                ->passwordInput(['maxlength' => true, 'placeholder' => 'Confirm new password'])
                ->label(false) ?>

                <div class="float-right col-md-offset-9 col-md-3 col-xs-offset-6 col-xs-6 pr-0">
                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>