<?php

use hail812\adminlte3\yii\grid\ActionColumn as GridActionColumn;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'is_deleted:boolean',
            [
                'class' => GridActionColumn::class,
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $urlPortrait = Url::toRoute(['portrait/view', 'id' => $key]);
                        return Html::a('', $urlPortrait, ['class' => 'fas fa-eye btn-sm btn-success', 'id' => 'view']);
                    },
                    'update' => function ($url, $model, $key) {
                        $urlPortrait = Url::toRoute(['portrait/update', 'id' => $key]);
                        return Html::a('', $urlPortrait, ['class' => 'fas fa-user-edit btn-sm btn-primary', 'id' => 'update']);
                    },
                    'delete' => function ($url, $model, $key) {
                        $urlPortrait = Url::toRoute(['portrait/delete', 'id' => $key]);
                            return Html::a('', $urlPortrait, [
                                'class' => 'fas fa-trash-alt btn-sm btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this user?',
                                    'method' => 'post',
                                ],
                            ]);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
