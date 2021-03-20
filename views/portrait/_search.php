<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PortraitSearch */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="portrait-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name_portrait') ?>

    <?= $form->field($model, 'last_name') ?>

    <?= $form->field($model, 'date_register') ?>

    <?= $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'repository') ?>

    <?php // echo $form->field($model, 'prestige_port') ?>

    <?php // echo $form->field($model, 'sex') ?>

    <?php // echo $form->field($model, 'us_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
