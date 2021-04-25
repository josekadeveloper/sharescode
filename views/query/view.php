<?php

use app\models\Answer;
use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="query-view">
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
                'attribute' => 'Portrait',
                'value' => Html::a(
                                'Access to user portrait', 
                                ['portrait/view', 'id' => $model->users_id], 
                                ['class' => 'btn btn-success']
                            ),
                'format' => 'html',
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
                'template' => '{accessto} {update} {delete}',
                'buttons' => [
                    'accessto' => function ($url, $model, $key) {
                        return Html::a(
                            "Access to user portrait",
                            [
                                'portrait/view',
                                'id' => $model->users_id,
                            ],
                            ['class' => 'btn btn-success']
                        );
                    },
                    'update' => function ($url, $model, $key) {
                        $urlAnswer = Url::toRoute(['answer/update', 'id' => $key]);
                        $users_id = Yii::$app->user->id;
                        if ($users_id !== null) {
                            if (Answer::findOne([
                                'id' => $key,
                                'users_id' => $users_id
                            ]) || Yii::$app->user->identity->is_admin === true) {
                                return Html::a('update', $urlAnswer, ['class' => 'btn btn-info']);
                            } 
                        }
                    },
                    'delete' => function ($url, $model, $key) {
                        $urlAnswer = Url::toRoute(['answer/delete', 'id' => $key]);
                        $users_id = Yii::$app->user->id;
                        if ($users_id !== null) {
                            if (Answer::findOne([
                                          'id' => $key,
                                          'users_id' => $users_id,
                                        ]) || Yii::$app->user->identity->is_admin === true) {
                                return Html::a('delete', $urlAnswer, [
                                        'class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this answers?',
                                            'method' => 'post',
                                        ],
                                    ]);
                            }
                        }
                    },
                ],
            ],
        ],
    ]); ?>
</div>
