<?php

use yii\bootstrap4\Html;

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Portraits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portrait-create">

    <?= $this->render('_form', [
        'model' => $model,
        'id' => $id,
    ]) ?>

</div>
