
<?php

use app\models\Portrait;
use yii\bootstrap4\Html;
use yii\widgets\DetailView;

$this->title = 'My Portrait';
$this->params['breadcrumbs'][] = $this->title;
?>
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
