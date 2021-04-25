<?php

use yii\bootstrap4\Html;

$this->title = 'Create Answer';
$this->params['breadcrumbs'][] = ['label' => 'Answers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-create">

    <?= $this->render('_form', [
        'model' => $model,
        'query_id' => $query_id,
        'users_id' => $users_id,
    ]) ?>

</div>
