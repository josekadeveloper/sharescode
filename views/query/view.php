<?php

use app\models\Answer;
use hail812\adminlte3\yii\grid\ActionColumn;
use yii\bootstrap4\Html;
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
        <?= Html::a(' Update query', ['update', 'id' => $model->id], ['class' => 'fas fa-user-edit btn-sm btn-primary']) ?>
        <?= Html::a(' Delete query', ['delete', 'id' => $model->id], [
            'class' => 'fas fa-trash-alt btn-sm btn-danger',
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
                                '', 
                                ['portrait/view', 'id' => $model->users_id], 
                                ['class' => 'fas fa-eye btn-sm btn-success']
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
                            '',
                            [
                                'portrait/view',
                                'id' => $model->users_id,
                            ],
                            ['class' => 'fas fa-eye btn-sm btn-success']
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
                                return Html::a('', $urlAnswer, ['class' => 'fas fa-user-edit btn-sm btn-primary']);
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
                                return Html::a('', $urlAnswer, [
                                        'class' => 'fas fa-trash-alt btn-sm btn-danger',
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
