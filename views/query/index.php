<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\QuerySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

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
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
        ],
    ]); ?>


</div>
