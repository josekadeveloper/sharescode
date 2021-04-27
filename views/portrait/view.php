<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

$this->title = $model->nickname;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="portrait-view">

<?php if ($model->id == $user_portrait || $user_portrait === 'admin'): ?>
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
