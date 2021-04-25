<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;

$urlQuery = Url::toRoute(['query/view', 'id' => $model->query_id]);
$this->title = 'Update Answer: ';
$this->params['breadcrumbs'][] = ['label' => 'Query', 'url' => $urlQuery];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="answer-update">

    <?= $this->render('_form', [
        'model' => $model,
        'query_id' => $query_id,
        'users_id' => $users_id,
    ]) ?>

</div>
