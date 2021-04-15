<?php

use yii\bootstrap4\Html;

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portrait-register">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_register', [
        'model' => $model,
        'id' => $id,
    ]) ?>

</div>