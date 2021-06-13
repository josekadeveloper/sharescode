<?php

use yii\widgets\DetailView;

?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="form col-md-6">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'title',
                    'dispatch',
                    'date_created:dateTime',
                ],
            ]) ?>
        </div>
    </div>
</div>