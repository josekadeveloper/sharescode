<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Register';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-register">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_register', [
        'model' => $model,
    ]) ?>

</div>