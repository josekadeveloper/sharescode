<?php

use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Queries';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="query-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Query', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title',
            'explanation:ntext',
            'date_created:date',
            'is_closed:boolean',
            [
                'class' => ActionColumn::class,
                'template' => '{view} {create}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('view', $url, ['class' => 'btn btn-info']);
                    },
                    'create' => function ($url, $model, $key) {
                        $urlAnswer = Url::toRoute(['query/view', 'id' => $key]);
                        return Html::a('answer', $urlAnswer, ['class' => 'btn btn-success']);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
