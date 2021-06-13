<?php

use hail812\adminlte3\yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="form col-md-12">
            <div class="card">
                <div class="card-body">

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            'title',
                            'dispatch',
                            'date_created:dateTime',
                            [
                                'class' => ActionColumn::class,
                                'template' => '{view} {read} {delete}',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        return Html::a('', $url, ['class' => 'fas fa-eye btn-sm btn-success', 'id' => 'view']);
                                    },
                                    'read' => function ($url, $model, $key) {
                                        return !$model->is_read ? Html::a('<i class="fas fa-envelope btn-sm btn-primary"></i>') :  Html::a('<i class="fas fa-envelope-open-text btn-sm btn-primary"></i>') ;
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('', $url, ['class' => 'fas fa-trash-alt btn-sm btn-danger', 'id' => 'delete']); 
                                    },
                                ],
                            ],
                        ],
                        'summaryOptions' => ['class' => 'summary mb-2'],
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                        ],
                        'options' => [
                            'class' => 'table table-responsive',
                        ]
                    ]); ?>


                </div>
            </div>
        </div>
    </div>
</div>
