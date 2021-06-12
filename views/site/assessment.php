<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$votes = [
  'wrong' => 'wrong',
  'regular' => 'regular',
  'good' => 'good',
  'very good' => 'very good',
];

?>
<div class="card text-center justify-content-center formulario">
  <div class="card-header">
    <h3><strong>Give us your objective opinion to improve</strong></h3>
  </div>
  <div class="card-body">
    <h5 class="card-text text-info">Select according to opinion of wrong, regular, good and very good</h5>
    <?php $form = ActiveForm::begin(); ?>

      <?= $form->field($model, 'typ')->textInput(['maxlength' => true])->dropDownList($votes, [
                           'style' => 'width: 150px !important; display: inline;',
      ])->label(false) ?>

      <?= $form->field($model, 'suggesting')->textarea(['rows' => '6', 'placeholder' => 'Post your opinion', 
                                                        'style'=>'width:50%; display:inline;'])->label(false) ?>

      <div class="form-group">
          <?= Html::submitButton('Send opinion', ['class' => 'btn btn-primary']) ?>
      </div>

    <?php ActiveForm::end(); ?>
  </div>
  <div class="card-footer text-muted">
    <?php if ($old_assessment > 20 && $old_assessment < 40): ?>
      <p class="text-danger"><strong>The opinions are very bad, help us to improve
                                 to give a good service to our users</strong></p>
      <p class="clasificacion">
        <label for="1">★</label>
      </p>
    <?php elseif ($old_assessment > 40 && $old_assessment < 60): ?>
      <p class="text-warning"><strong>The opinions in general are not very good, 
                                but we are improving day after day, 
                                help us to continue improving</strong></p>
      <p class="clasificacion">
        <label for="1">★</label>
        <label for="2">★</label>
      </p>
    <?php elseif ($old_assessment > 60 && $old_assessment < 80): ?>
      <p class="text-info"><strong>Opinions are good from the largest half of our users, 
                                help us to keep improving</strong></p>
      <p class="clasificacion">
        <label for="1">★</label>
        <label for="2">★</label>
        <label for="3">★</label>
      </p>
    <?php elseif ($old_assessment > 80 && $old_assessment < 100): ?>
      <p class="text-primary"><strong>Opinions are highly positive, help us to 
                                give a perfect service</strong></p>
      <p class="clasificacion">
        <label for="1">★</label>
        <label for="2">★</label>
        <label for="3">★</label>
        <label for="4">★</label>
      </p>
    <?php elseif ($old_assessment === 100): ?>
      <p class="text-success"><strong>The result of our work is bearing fruit, 
                                but with your opinion we will continue to improve</strong></p>
      <p class="clasificacion">
        <label for="1">★</label>
        <label for="2">★</label>
        <label for="3">★</label>
        <label for="4">★</label>
        <label for="5">★</label>
      </p>
    <?php endif ?>
    Thanks for your time
  </div>
</div>