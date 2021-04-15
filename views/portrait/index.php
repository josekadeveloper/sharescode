
<?php

use yii\grid\GridView;

$this->title = 'Portrait List';
$this->params['breadcrumbs'][] = $this->title;
?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'nickname',
            'date_register:date',
            'email:email',
            'repository:url',
            'prestige_port',
            'sex',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

