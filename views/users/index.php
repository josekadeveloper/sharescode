<?php

use app\models\Portrait;
use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Users', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'is_deleted:boolean',
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $urlPortrait = Url::toRoute(['portrait/view', 'id' => $key]);
                        return Html::a('view', $urlPortrait, ['class' => 'btn btn-info', 'id' => 'view']);
                    },
                    'update' => function ($url, $model, $key) {
                        $urlPortrait = Url::toRoute(['portrait/update', 'id' => $key]);
                        return Html::a('update', $urlPortrait, ['class' => 'btn btn-success', 'id' => 'update']);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
