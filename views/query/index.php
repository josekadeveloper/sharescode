<?php

use app\models\Portrait;
use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Queries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="query-index">

<?php if (Portrait::findOne(['id' => Yii::$app->user->id])): ?>
    <p>
        <?= Html::a('Create Query', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php endif ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title',
            'explanation:ntext',
            'lastAnswer:ntext',
            'date_created:dateTime',
            'is_closed:boolean',
            [
                'class' => ActionColumn::class,
                'template' => '{view} {create}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('view', $url, ['class' => 'btn btn-info', 'id' => 'view']);
                    },
                    'create' => function ($url, $model, $key) {
                        $urlAnswer = Url::toRoute(['answer/create', 'id' => $key]);
                        if (Portrait::findOne(['id' => Yii::$app->user->id])) {
                            return Html::a('answer', $urlAnswer, ['class' => 'btn btn-success', 'id' => 'answer']);
                        } 
                    },
                ],
            ],
        ],
    ]); ?>


</div>
