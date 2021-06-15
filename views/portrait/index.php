<?php

use yii\grid\GridView;
use hail812\adminlte3\yii\grid\ActionColumn as GridActionColumn;
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
                [
                    'class' => GridActionColumn::class,
                    'template' => '{view}',
                ],
            ],
            'options' => [
                'class' => 'table table-responsive',
            ]
        ]); ?>
    </div>
</div>
