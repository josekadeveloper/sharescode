<?php

use yii\helpers\Url;
use yii\widgets\DetailView;

$urlReminder = Url::to(['reminder/index']);
?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="form col-md-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="query/index">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= $urlReminder ?>">Reminders List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Reminder</li>
                </ol>
            </nav>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'title',
                    'dispatch',
                    'date_created:dateTime',
                ],
            ]) ?>
        </div>
    </div>
</div>