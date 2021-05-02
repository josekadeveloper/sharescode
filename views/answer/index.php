<?php

use yii\grid\GridView;

$this->title = 'Answers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row justify-content-center">
    <div class="answer-index formulario col-md-6" style="margin-bottom: 28.2vw;">

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
</div>
