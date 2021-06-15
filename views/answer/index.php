<?php

use yii\grid\GridView;

?>
<div class="row justify-content-center">
    <div class="answer-index form col-md-12">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'query.title',
                ['class' => 'yii\grid\ActionColumn'],
            ],
            'options' => [
                'class' => 'table table-responsive',
            ]
            
        ]); ?>


    </div>
</div>
