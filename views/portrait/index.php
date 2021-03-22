
<?php

use app\models\Portrait;
use yii\bootstrap4\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PortraitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mi perfil';
$this->params['breadcrumbs'][] = $this->title;
?>
    <p>
        <?= Html::a('Update portrait', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete portrait', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estas seguro de querer borrar su perfil?',
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
