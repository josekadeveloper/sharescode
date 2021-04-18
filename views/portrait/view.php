<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

$this->title = $model->nickname;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="portrait-view">

    <h1><?= Html::encode($this->title) ?></h1>
<?php if ($model->id == $user_portrait || $user_portrait === 'admin'): ?>
    <p>
        <?= Html::a('Update portrait', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete portrait', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete your Portrait?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<?php endif ?>
    <p>
        <?= $img = $model->devolverImg($model) ?>            
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
                'nickname',
                'date_register:date',
                'email:email',
                'repository:url',
                'prestige_port',
                'sex',
        ],
    ]); ?>
