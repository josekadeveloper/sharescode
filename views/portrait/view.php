<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

?>
<div class="row justify-content-center">
    <div class="portrait-view formulario col-md-6" style="margin-bottom: 2.7vw;">

    <?php if (Yii::$app->user->id): ?>
        <?php if ($model->id == $user_id || $model_portrait->is_admin === true): ?>
            <p>
                <?= Html::a('', ['update', 'id' => $model->id], ['class' => 'fas fa-user-edit btn-sm btn-primary']) ?>
                <?= Html::a('', ['delete', 'id' => $model->id], [
                    'class' => 'fas fa-trash-alt btn-sm btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete your Portrait?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        <?php endif ?>
    <?php endif ?>
        <p id="img-portrait">
            <?= $img = $model->devolverImg($model) ?>
        </p>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                    'nickname',
                    'date_register:date',
                    'email:email',
                    'repository:url',
                    [
                        'label' => 'Prestige Port',
                        'format' => 'html',
                        'value' => Html::a($model->prestige_port, ['/prestige/view', 'id' => $prestige_id]),
                    ],
                    'sex',
            ],
        ]); ?>
    </div>
</div>