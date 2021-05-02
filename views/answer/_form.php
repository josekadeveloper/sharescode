<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

?>
<div class="row justify-content-center">
    <div class="answer-form formulario col-md-6" style="margin-bottom: 23.8vw;">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'date_created')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false) ?>

        <?= $form->field($model, 'query_id')->hiddenInput(['value' => $query_id])->label(false) ?>

        <?= $form->field($model, 'users_id')->hiddenInput(['value' => $users_id])->label(false)  ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
