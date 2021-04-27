<?php

use app\models\Portrait;
use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ListView;

?>

<div class="query-index">

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_post',
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title',
            'explanation:ntext',
            'lastAnswer:ntext',
            'date_created:dateTime',
            'is_closed:boolean',
            [
                'class' => ActionColumn::class,
                'template' => '{view} {create}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('', $url, ['class' => 'fas fa-eye btn-sm btn-success', 'id' => 'view']);
                    },
                    'create' => function ($url, $model, $key) {
                        $urlAnswer = Url::toRoute(['answer/create', 'id' => $key]);
                        if (Portrait::findOne(['id' => Yii::$app->user->id])) {
                            return Html::a('', $urlAnswer, ['class' => 'fas fa-reply btn-sm btn-primary', 'id' => 'answer']);
                        } 
                    },
                ],
            ],
        ],
    ]); ?>


</div>
