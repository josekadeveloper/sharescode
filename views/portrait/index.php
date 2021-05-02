<?php

use yii\grid\GridView;

$this->title = 'Portrait List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row justify-content-center">
    <div class="portrait-index formulario col-md-6" style="margin-bottom: 21.6vw;">
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
    </div>
</div>
