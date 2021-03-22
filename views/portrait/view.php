<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Portrait */

$this->title = $model->name_portrait;
$this->params['breadcrumbs'][] = ['label' => 'Portraits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$d = date('Y-m-d H:m:s');
$date = Yii::$app->formatter->asDate($d); 
?>
<div class="portrait-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update portrait', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete portrait', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <p>
        <?= $img = $model->devolverImg($model) ?>            
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
                'name_portrait',
                'last_name',
                'date_register:date',
                'email:email',
                'repository:url',
                'prestige_port',
                'sex',
                [
                    'label' => 'User',
                    'value' => $nickname,
                ],
        ],
    ]); ?>
