<?php

use yii\bootstrap4\Html;

?>
<div class="row justify-content-center">
    <div class="answer-view form col-md-6">
        <p>
            <?= Html::a('', ['update', 'id' => $model->id], ['class' => 'fas fa-user-edit btn-sm btn-primary']) ?>
            <?= Html::a('', ['delete', 'id' => $model->id], [
                'class' => 'fas fa-trash-alt btn-sm btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this answers?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
        <!-- /.card-body -->
        <div class="card-footer card-comments">
            <div class="card-comment">
                <div class="comment-text">
                    <?= $model->content ?>
                </div>
            </div>
            <!-- /.card-comment -->
        </div>
    </div>
</div>
