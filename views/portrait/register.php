<?php

use yii\bootstrap4\Html;

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portrait-register">

    <?= $this->render('_register', [
        'model' => $model,
    ]) ?>

</div>