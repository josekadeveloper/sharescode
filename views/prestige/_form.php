<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Prestige */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="prestige-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type_prestige')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'antiquity')->textInput() ?>

    <?= $form->field($model, 'score')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
