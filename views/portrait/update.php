<?php

use yii\bootstrap4\Html;

$this->title = 'Update Portrait: ' . $model->name_portrait;
$this->params['breadcrumbs'][] = ['label' => 'Portraits', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Mi perfil', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="portrait-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
