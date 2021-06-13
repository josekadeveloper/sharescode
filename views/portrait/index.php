<?php

use yii\grid\GridView;

?>
<div class="row justify-content-center">
    <div class="portrait-index form col-md-12">
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
            'options' => [
                'class' => 'table table-responsive',
            ]
        ]); ?>
    </div>
</div>
