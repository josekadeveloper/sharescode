<?php

use app\models\Answer;
use app\models\Portrait;
use app\models\Query;
use yii\helpers\Html;
use yii\helpers\Url;

$urlPortrait = Url::to(['portrait/view', 'id' => $model->users_id]);
$username = Query::findUserName($model->id);
$img = Query::findUserImage($model->id);
$answers_list = $model->answers;

if (Yii::$app->user->id !== null) {
    $user_actually_id = Yii::$app->user->id;
    $model_portrait = Portrait::findOne(['id' => $user_actually_id]);
    $model_portrait->sex === 'Men'
    ? $url = '@web/img/men.svg'
    : $url = '@web/img/woman.svg';
    $img_response = Html::img($url, ['class'=> 'img-answer']);
} else {
    $user_actually_id = null;
}
?>
<div class="row justify-content-center mt-5">
    <div class="col-md-9 card card-widget">
        <div class="card-header">
            <div class="user-block">
                <div class="img-circle" alt="User Image">
                    <?= $img ?>
                </div>
                    <span class="username"><a href=<?= $urlPortrait ?>><?= Html::encode($username) ?></a></span>
                    <span class="description">Created ago - <?= $model->date_created ?> </span>
            </div>
        <!-- /.user-block -->
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <span class="text-primary"><?= $model->title ?> </span>
        </div>
        <!-- /.card-tools -->
        </div>
              
        <!-- /.card-header -->
        <div class="card-body">
            <!-- post text -->
            <h3 class="text-success"><?= $model->title ?></h3>
            <!-- Attachment -->
            <div class="attachment-block clearfix">
                <div class="attachment-text">
                    <p><?= $model->explanation ?></p>
                </div>
            </div>
            <!-- /.attachment-block -->
        </div>
        <?php foreach ($answers_list as $answer): ?>
            <!-- /.card-body -->
            <div class="card-footer card-comments">
                <div class="card-comment">
                    <!-- User image -->
                    <div class="img-circle" alt="User Image">
                        <?= Answer::findUserImage($answer->users_id) ?>
                    </div>

                    <div class="comment-text">
                        <span class="username">
                            <a href=<?= Answer::findUserPortrait($answer->users_id) ?>><?= Answer::findUserName($answer->users_id) ?></a>
                        <span class="text-muted float-right"><?= $answer->date_created ?></span>
                        </span><!-- /.username -->
                        <?= $answer->content ?>
                    </div>
                    <hr>
                    <!-- Social sharing buttons -->
                    <button type="button" class="btn btn-default btn-sm"><i class="fas fa-share"></i> Share</button>
                    <button type="button" class="btn btn-default btn-sm"><i class="far fa-thumbs-up"></i> Like</button>
                    <span class="float-right text-muted">45 likes - 2 comments</span>
                    <!-- /.comment-text -->
                </div>
                <!-- /.card-comment -->
            </div>
        <?php endforeach ?>
        <?php if ($user_actually_id): ?>
            <!-- /.card-footer -->
            <div class="card-footer mb-3">
                <form action="#" method="post">
                    <!-- User image -->
                    <div class="img-fluid img-circle img-sm">
                        <?= $img_response ?>
                    </div>
                    <!-- .img-push is used to add margin to elements next to floating images -->
                    <div class="img-push">
                        <input type="text" class="form-control form-control-sm" placeholder="Press enter to post comment">
                    </div>
                </form>
            </div>
            <!-- /.card-footer -->
        <?php endif ?>
    </div>
</div>
