<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;

$urlQuery = Url::toRoute(['query/view', 'id' => $model->query_id]);
$this->title = 'Update Answer: ';
$this->params['breadcrumbs'][] = ['label' => 'Query', 'url' => $urlQuery];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="answer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'id' => $id,
        'portrait_id' => $portrait_id,
    ]) ?>

</div>
