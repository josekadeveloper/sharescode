<?php

use yii\helpers\Url;

$urlAnswersList = Url::to(['answer/index']);
?>
<div class="row justify-content-center">
    <div class="answer-view form col-md-6">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="query/index">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= $urlAnswersList ?>">Answers List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Answer</li>
            </ol>
        </nav>
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
