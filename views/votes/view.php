<?php

use app\models\Portrait;
use yii\widgets\DetailView;

?>

<div class="container-fluid justify-content-center form">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'typ',
                            'puntuation',
                            'suggesting',
                            [
                                'label' => 'User',
                                'value' => Portrait::findNicknameById($model->users_id), 
                            ],
                        ],
                    ]) ?>
                </div>
                <!--.col-md-12-->
            </div>
            <!--.row-->
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>