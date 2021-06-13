<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

\yii\web\YiiAsset::register($this);

?>
<div class="row justify-content-center">
    <div class="answer-view form col-md-6">
        <p>
            <?= Html::a('', ['update', 'id' => $model->id], ['class' => 'fas fa-user-edit btn-sm btn-primary']) ?>
            <?= Html::a('', ['delete', 'id' => $model->id], [
                'class' => 'fas fa-trash-alt btn-sm btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this answers?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'content',
            ],
        ]) ?>
    </div>
</div>
