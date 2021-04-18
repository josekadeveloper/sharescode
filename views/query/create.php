<?php

use yii\bootstrap4\Html;

$this->title = 'Create Query';
$this->params['breadcrumbs'][] = ['label' => 'Queries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="query-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'portrait_id' => $portrait_id,
    ]) ?>

</div>
