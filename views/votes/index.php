<?php

use app\models\Portrait;
use yii\grid\GridView;
use hail812\adminlte3\yii\grid\ActionColumn as GridActionColumn;

?>
<div class="container-fluid justify-content-center form-votes">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php if ($old_assessment > 20 && $old_assessment < 40): ?>
                <p class="text-danger"><strong>The opinions are very bad</strong></p>
                <p class="clasificacion">
                    <label for="1">★</label>
                </p>
            <?php elseif ($old_assessment > 40 && $old_assessment < 60): ?>
                <p class="text-warning"><strong>The opinions in general are not very good</strong></p>
                <p class="clasificacion">
                    <label for="1">★</label>
                    <label for="2">★</label>
                </p>
            <?php elseif ($old_assessment > 60 && $old_assessment < 80): ?>
                <p class="text-info"><strong>Opinions are good from the largest half of our users</strong></p>
                <p class="clasificacion">
                    <label for="1">★</label>
                    <label for="2">★</label>
                    <label for="3">★</label>
                </p>
            <?php elseif ($old_assessment > 80 && $old_assessment < 100): ?>
                <p class="text-primary"><strong>Opinions are highly positive</strong></p>
                <p class="clasificacion">
                    <label for="1">★</label>
                    <label for="2">★</label>
                    <label for="3">★</label>
                    <label for="4">★</label>
                </p>
            <?php elseif ($old_assessment === 100): ?>
                <p class="text-success"><strong>The result of our work is bearing fruit</strong></p>
                <p class="clasificacion">
                    <label for="1">★</label>
                    <label for="2">★</label>
                    <label for="3">★</label>
                    <label for="4">★</label>
                    <label for="5">★</label>
                </p>
            <?php endif ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            'typ',
                            'puntuation',
                            'suggesting',
                            [
                                'label' => 'User',
                                'value' => function ($dataProvider) {
                                    foreach ($dataProvider as $key => $value) {
                                        if ($key === 'users_id') {
                                            return Portrait::findNicknameById($value);
                                        }
                                    }
                                },
                            ],
                            [
                                'class' => GridActionColumn::class,
                                'template' => '{view}',
                            ],
                        ],
                        'summaryOptions' => ['class' => 'summary mb-2'],
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                        ],
                        'options' => [
                            'class' => 'table table-responsive',
                        ]
                    ]); ?>
                </div>
                <!--.card-body-->
            </div>
            <!--.card-->
        </div>
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>
