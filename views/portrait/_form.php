<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$usu_id = Yii::$app->user->identity->id;
$sex = ['Men' => 'Men',
        'Woman' => 'Woman'];
?>

<div class="portrait-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name_portrait')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_register')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'repository')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prestige_port')->hiddenInput(['maxlength' => true, 'value' => 'Initiate'])->label(false) ?>

    <?= $form->field($model, 'sex')->textInput(['maxlength' => true])->dropDownList($sex)  ?>

    <?= $form->field($model, 'us_id')->hiddenInput(['value' => $usu_id])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
