
<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PortraitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mi perfil';
$this->params['breadcrumbs'][] = $this->title;
$d = date('Y-m-d H:m:s');
$date = Yii::$app->formatter->asDate($d);
?>
<div class="portrait-index">
<?php if($model2 === null): ?>
        <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::button('Crear perfil', ['class' => 'btn btn-success', 'id' => 'btn']) ?>
    </p>
</div>
<div class="portrait-create">
<?php $this->title = 'Crear perfil: ' ?>
    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
<?php else: ?>
    <p>
        <?= Html::a('Editar perfil', ['update', 'id' => $model2->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar perfil', ['delete', 'id' => $model2->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estas seguro de querer borrar su perfil?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <p>
        <?= $img = $model2->devolverImg($model2); ?>            
    </p>
    <?= DetailView::widget([
        'model' => $model2,
        'attributes' => [     
                'name_portrait',
                'last_name',
                [
                    'label' => 'Date register',
                    'value' => $date,
                ],
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
<?php endif ?>