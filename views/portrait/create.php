<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Portrait */

$this->title = 'Create Portrait';
$this->params['breadcrumbs'][] = ['label' => 'Portraits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portrait-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
