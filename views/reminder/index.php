<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

$this->title = 'Reminders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reminder-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title:text',
            'dispatch:text',
            'date_created:dateTime',
            'is_read:boolean',
            [
                'label' => 'Transmitter User',
                'value' => 'nickname'
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
