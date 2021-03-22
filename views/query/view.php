<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Query */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Queries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="query-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update query', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete query', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'date_created:date',
            [
                'attribute' => 'portrait_id',
                'value' => $nombre_perfil,
            ],
        ],
    ]) ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'explanation:ntext',
        ],
    ]) ?>

</div>

</div>
