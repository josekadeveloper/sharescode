<?php

use yii\widgets\DetailView;

?>

<div class="row justify-content-center">
    <div class="prestige-view form col-md-6">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="query/index">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Prestige</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'title',
                                    [
                                        'label' => 'Antiquity',
                                        'value' => $antiquity,
                                    ],
                                    'puntuation',
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
    </div>
</div>