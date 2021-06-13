<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="portrait form">
    <div class="col-md-12">
        <h3><strong>¿Did you forget your password?</strong></h3>
        <hr>
        <div class="col-md-offset-3 col-md-12">
            <div class="row justify-content-center">
                <?php $form = ActiveForm::begin([
                    'id' => 'recovery-form',
                    'method' => 'post',
                    'action' => ['portrait/recovery-pass']
                ]) ?>
                    <?= $form->field($model, 'email')
                    ->textInput(['maxlength' => true, 'placeholder' => 'Email'])
                    ->label(false) ?>

                    <div class="float-right col-md-12 pr-0">
                        <div class="form-group">
                            <?= Html::submitButton('Restore password', ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>