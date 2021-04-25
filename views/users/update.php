<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Update Users: ';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nickname, 'url' => ['view', 'id' => $model->id]];
?>
<div class="users-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
