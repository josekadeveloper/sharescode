<?php

use yii\bootstrap4\Html;

$this->title = 'Update Query: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Queries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="query-update">

    <?= $this->render('_form', [
        'model' => $model,
        'users_id' => $users_id,
    ]) ?>

</div>
