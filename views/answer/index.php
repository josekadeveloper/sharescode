<?php

use yii\grid\GridView;
use hail812\adminlte3\yii\grid\ActionColumn as GridActionColumn;

?>
<div class="row justify-content-center">
    <div class="answer-index form col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="query/index">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Answers List</li>
            </ol>
        </nav>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'query.title',
                [
                    'class' => GridActionColumn::class,
                    'template' => '{view}',
                ],
            ],
            'options' => [
                'class' => 'table table-responsive',
            ]
            
        ]); ?>


    </div>
</div>
