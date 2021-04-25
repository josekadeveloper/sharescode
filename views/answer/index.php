<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

$this->title = 'Answers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-index">

    <p>
        <?= Html::a('Create Answer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'content',
            'query_id',
            'us_id',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
