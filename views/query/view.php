<?php

use app\models\Answer;
use app\models\Portrait;
use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;
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
<?php if ($owner_id !== null): ?>
    <p>
        <?= Html::a('Update query', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete query', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this query?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<?php endif ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'date_created:date',
            [
                'attribute' => 'portrait_id',
                'value' => $name_portrait,
            ],
        ],
    ]) ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'explanation:ntext',
        ],
    ]) ?>
<h2>ANSWERS</h2>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'content:ntext',
            'date_created:dateTime',
            [
                '__class' => ActionColumn::class, 
                'template' => '{accessto} {update}',
                'buttons' => [
                    'accessto' => function ($url, $model, $key) {
                        return Html::a(
                            "Access to user portrait",
                            [
                                'portrait/view',
                                'id' => $model->portrait_id,
                            ],
                        );
                    },
                    'update' => function ($url, $model, $key) {
                        $urlAnswer = Url::toRoute(['answer/update', 'id' => $key]);
                        $portrait_id = Portrait::findOne(['us_id' => Yii::$app->user->id]);
                        if ($portrait_id !== null){
                            $portrait_id = $portrait_id['id'];
                        }
                        if (Answer::findOne([
                                          'id' => $key,
                                          'portrait_id' => $portrait_id
                                        ])) {
                            return Html::a('update', $urlAnswer, ['class' => 'btn btn-info']);
                        } 
                    },
                ],
            ],
        ],
    ]); ?>
</div>
