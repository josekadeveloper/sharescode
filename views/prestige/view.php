<?php

use yii\widgets\DetailView;

?>

<div class="row justify-content-center">
    <div class="prestige-view formulario col-md-6" style="margin-bottom: 2.7vw;">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'label' => 'User',
                                        'value' => $nickname,
                                    ],
                                    'type_prestige',
                                    [
                                        'label' => 'Antiquity',
                                        'value' => $antiquity,
                                    ],
                                    'score',
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