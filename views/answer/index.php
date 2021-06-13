<?php

use yii\grid\GridView;

$this->title = 'Answers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row justify-content-center">
    <div class="answer-index form col-md-12">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'content',
                'query.title',
                'user.portrait.nickname',
                ['class' => 'yii\grid\ActionColumn'],
            ],
            'options' => [
                'class' => 'table table-responsive',
            ]
            
        ]); ?>


    </div>
</div>
