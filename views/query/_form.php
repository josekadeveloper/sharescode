<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

?>
<div class="row justify-content-center">
    <div class="query-form form col-md-4">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'explanation')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'date_created')->hiddenInput(['value' => $date_created])->label(false) ?>

        <?= $form->field($model, 'is_closed')->checkbox()->label(false) ?>

        <?= $form->field($model, 'users_id')->hiddenInput(['value' => $users_id])->label(false)  ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>