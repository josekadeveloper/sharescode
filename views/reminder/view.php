<?php

use yii\widgets\DetailView;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Reminders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="formulario col-md-6" style="margin-bottom: 29.1vw;">
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