<?php

use app\models\Answer;
use app\models\Portrait;
use app\models\Query;
use app\models\Users;
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerJsFile('@web/js/codemirror.js', ['position' => $this::POS_END]);
$this->registerCssFile('@web/css/codemirror.css', ['position' => $this::POS_HEAD]);
$this->registerCssFile('@web/theme/dracula.css', ['position' => $this::POS_HEAD]);
$this->registerJsFile('@web/mode/javascript.js', ['position' => $this::POS_END]);
$this->registerJsFile('@web/mode/php.js', ['position' => $this::POS_END]);

$model_user_actually = Portrait::findOne(['id' => Yii::$app->user->id]);
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

$url_create = Url::to(['answer/create', 'id' => $model->id]);
$url_delete = Url::to(['answer/delete']);
$url_update = Url::to(['answer/update']);
$url_vote = Url::to(['answer/vote']);
$createAnswer = <<<EOT
var cm = CodeMirror.fromTextArea(document.getElementById("codemirror-$model->id", {}));

cm.setSize(600, 200);
cm.setOption("lineNumbers", true);
cm.setOption("tableSize", 5);
cm.setOption("theme", "dracula");

$('#form-codemirror-$model->id').submit(function (ev) {
    ev.preventDefault();
    var content = $('#codemirror-$model->id').val();

    $.ajax({
        type: 'POST',
        url: '$url_create',
        data: {
            content: content,
        }
    })
    .done(function (data) {
        let newAnswer = $(data.response);
        newAnswer.hide();
        $('#answers-$model->id').append(newAnswer);
        newAnswer.fadeIn('fast');
        $('#modals-$model->id').append(data.modal);

        let deleteButton = $('#delete-' + data.answer_id);
        let updateButton = $('#update-' + data.answer_id);

        deleteButton.click(function (ev) {
            ev.preventDefault();
            var id = data.answer_id;

            $.ajax({
                type: 'POST',
                url: '$url_delete',
                data: {
                    id: id,
                }
            })
            .done(function (data) {
                let container = $('#container-answer-'+id);
                container.fadeOut('fast', function() {
                    container.remove();
                });
                        
                $('li.dropdown').remove();
                $('#notifications').append(data.reminders);
            });
            return false;
        })
                
        updateButton.click(function(ev) {
            ev.preventDefault();
            let id = data.answer_id;

            let cont1 = $('#container-answer-'+id).find('.comment-text').text();
            let cont2 = $.trim($.trim(cont1.substr(23)));
            let content = $('#con-'+id);
            content.val(cont2);
                
            $('#send-'+id).click(function (ev) {
                var content = $('#con-'+id).val();

                $.ajax({
                    type: 'POST',
                    url: '$url_update',
                    data: {
                        id: id,
                        content: content,
                    }
                })
                .done(function (data) {
                    $('.fade').modal('hide');
        
                    let answer_id = data.answer_id;
                    let oldAnswer = $('#container-answer-'+answer_id);
                    oldAnswer.fadeOut('fast', function() {
                        oldAnswer.remove();
                    });
        
                    let newAnswer = $(data.response);
                                
                    let father_id = $('#update-'+answer_id).parent().parent().parent().attr("id");
                    $('#'+father_id).append(newAnswer);
                    newAnswer.fadeIn('fast');
                    $('#con-'+id).val('');
                    $('#con-'+id).val(content);


                    $('.card-comment').on('click', '#delete-' + data.answer_id, function(){
                        $.ajax({
                            type: 'POST',
                            url: '$url_delete',
                            data: {
                                id: id,
                            }
                        })
                        .done(function (data) {
                            let container = $('#container-answer-'+answer_id);
  
                            container.fadeOut('fast', function() {
                                container.remove();
                            });
                                
                            $('li.dropdown').remove();
                            $('#notifications').append(data.reminders);
                        });
                        return false;
                    });
                    $('li.dropdown').remove();
                    $('#notifications').append(data.reminders);
                })
                return false;
            });
        })
        $('li.dropdown').remove();
        $('#notifications').append(data.reminders);
    });
    return false;
});
EOT;

$deleteAnswer = <<<EOT
    var list = [];
    $(".delete").each(function(index) {
        list.push($(this).attr("id"));
    });

    $.each(list, function (ind, elem) {
        $('#'+elem).click(function (ev) {
            ev.preventDefault();
            var id = elem.substring(7);

            $.ajax({
                type: 'POST',
                url: '$url_delete',
                data: {
                    id: id,
                }
            })
            .done(function (data) {
                let container = $('#'+elem).parent().parent();

                container.fadeOut('fast', function() {
                    container.remove();
                });

                $('li.dropdown').remove();
                $('#notifications').append(data.reminders);
            });
            return false;
        });
    });
EOT;

$updateAnswer = <<<EOT
    var list = [];
    $(".update").each(function(index) {
        list.push($(this).attr("id"));
    });

    $.each(list, function (ind, elem) {
        $('#'+elem).click(function (ev) {
            ev.preventDefault();
            let id = elem.substring(7);

            let cont1 = $('#container-answer-'+id).find('.comment-text').text();
            let cont2 = $.trim($.trim(cont1.substr(23)).substr(131));
            let content = $('#con-'+id);
            content.val(cont2);
            
            $('#send-'+id).click(function (ev) {
                var content = $('#con-'+id).val();

                $.ajax({
                    type: 'POST',
                    url: '$url_update',
                    data: {
                        id: id,
                        content: content,
                    }
                })
                .done(function (data) {
                    $('.fade').modal('hide');

                    let answer_id = data.answer_id;
                    let oldAnswer = $('#container-answer-'+answer_id);
                    oldAnswer.fadeOut('fast', function() {
                        oldAnswer.remove();
                    });

                    let newAnswer = $(data.response);
                    
                    let father_id = $('#update-'+answer_id).parent().parent().parent().attr("id");
                    $('#'+father_id).append(newAnswer);
                    newAnswer.fadeIn('fast');
                    $('#con-'+id).val('');
                    $('#con-'+id).val(content);

                    $('.card-comment').on('click', '#delete-' + data.answer_id, function(){
                        var id = data.answer_id;

                        $.ajax({
                            type: 'POST',
                            url: '$url_delete',
                            data: {
                                id: id,
                            }
                        })
                        .done(function (data) {
                            let container = $('#container-answer-'+answer_id);
                            
                            container.fadeOut('fast', function() {
                                container.remove();
                            });
                                
                            $('li.dropdown').remove();
                            $('#notifications').append(data.reminders);
                        });
                        return false;
                    });

                    $('li.dropdown').remove();
                    $('#notifications').append(data.reminders);
                })
                return false;
            });
        });
    });
    
EOT;

$voteAnswer = <<<EOT
    var list = [];
    $(".vote").each(function(index) {
        list.push($(this).attr("id"));
    });

    $.each(list, function (ind, elem) {
        $('#'+elem).click(function (ev) {
            ev.preventDefault();
            var id = elem.substring(5);

            $.ajax({
                type: 'POST',
                url: '$url_vote',
                data: {
                    id: id,
                }
            })
            .done(function (data) {
                let answer_id = data.answer_id;
                let oldAnswer = $('#container-answer-'+answer_id);
                oldAnswer.fadeOut('fast', function() {
                    oldAnswer.remove();
                });

                let newAnswer = $(data.response);
  
                let father_id = $('#vote-'+answer_id).parent().parent().parent().attr("id");
                $('#'+father_id).append(newAnswer);
                newAnswer.fadeIn('fast');
            });
            return false;
        });
    });
EOT;
if (!Yii::$app->user->isGuest) {
    $this->registerJs($createAnswer);
    $this->registerJs($deleteAnswer);
    $this->registerJs($updateAnswer);
    $this->registerJs($voteAnswer);
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
                    <span class="description">Created ago - <?= date("d/m/Y H:i:s", strtotime($model->date_created)) ?> </span>
            </div>
        <!-- /.user-block -->
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <?php if (!Yii::$app->user->isGuest): ?>
                <?php if ($model->users_id === Yii::$app->user->id || $model_user_actually->is_admin === true): ?>
                    <?= Html::a('', ['query/delete', 'id' => $model->id], [
                        'class' => 'fas fa-minus-circle btn-danger btn-sm',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this Query?',
                            'method' => 'post',
                        ],
                    ])?>
                    <?= Html::a('', ['query/update', 'id' => $model->id], [
                        'class' => 'fas fa-edit btn-primary btn-sm',
                    ])?>
                <?php endif ?>
            <?php endif ?>
            <span class="text-primary"><?= $model->title ?></span>
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
            <div id="answers-<?= $model->id ?>">
                <?php foreach ($answers_list as $answer): ?>
                    <?php if (Answer::bestAnswer($model->id, $answer->id)): ?>
                        <!-- /.card-body -->
                        <div id="container-answer-<?= $answer->id ?>" class="card-footer card-comments bestAnswer">
                            <div class="card-comment">
                                <!-- User image -->
                                <div class="img-circle" alt="User Image">
                                    <?= Answer::findUserImage($answer->users_id) ?>
                                </div>

                                <div class="comment-text">
                                    <span class="username">
                                        <a href=<?= Answer::findUserPortrait($answer->users_id) ?>><?= Answer::findUserName($answer->users_id) ?></a>
                                    <span class="text-muted float-right"><?= date("d/m/Y H:i:s", strtotime($answer->date_created)) ?></span>
                                    </span><!-- /.username -->
                                    <?= $answer->content ?>
                                </div>
                                <hr>
                                <?php if ($answer->users_id === Yii::$app->user->id || $model_user_actually->is_admin === true): ?>
                                    <!-- Delete or update answer -->
                                    <button type="button" id="delete-<?= $answer->id ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-minus-circle"></i> Delete</button>
                                    <button type="button" id="update-<?= $answer->id ?>" class="btn btn-primary btn-sm update" data-toggle="modal" data-target="#ex-<?= $answer->id ?>">
                                        <i class="far fa-edit"></i> Update
                                    </button>
                                <?php endif ?>
                                <?php if (Yii::$app->user->id && $answer->users_id !== Yii::$app->user->id): ?>
                                    <?php if (Users::checkVote($answer->id, Yii::$app->user->id)): ?>
                                        <!-- Social sharing buttons -->
                                        <button type="button" id="vote-<?= $answer->id ?>" class="btn btn-success btn-sm voted"><i class="far fa-thumbs-up"></i> Like</button>
                                    <?php else: ?>
                                        <!-- Social sharing buttons -->
                                        <button type="button" id="vote-<?= $answer->id ?>" class="btn btn-default btn-sm vote"><i class="far fa-thumbs-up"></i> Like</button>
                                    <?php endif ?>
                                <?php endif ?>
                                <i id="icon-check" class="ml-2 float-right fas fa-check"></i>
                                <span class="float-right text-muted"><?= $answer->likes ?> likes</span>
                                <!-- /.comment-text -->
                            </div>
                            <!-- /.card-comment -->
                        </div>
                    <?php else: ?>
                        <!-- /.card-body -->
                        <div id="container-answer-<?= $answer->id ?>" class="card-footer card-comments">
                            <div class="card-comment">
                                <!-- User image -->
                                <div class="img-circle" alt="User Image">
                                    <?= Answer::findUserImage($answer->users_id) ?>
                                </div>

                                <div class="comment-text">
                                    <span class="username">
                                        <a href=<?= Answer::findUserPortrait($answer->users_id) ?>><?= Answer::findUserName($answer->users_id) ?></a>
                                    <span class="text-muted float-right"><?= date("d/m/Y H:i:s", strtotime($answer->date_created)) ?></span>
                                    </span><!-- /.username -->
                                    <?= $answer->content ?>
                                </div>
                                <hr>
                                <?php if (!Yii::$app->user->isGuest): ?>
                                    <?php if ($answer->users_id === Yii::$app->user->id || $model_user_actually->is_admin === true): ?>
                                        <!-- Delete or update answer -->
                                        <button type="button" id="delete-<?= $answer->id ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-minus-circle"></i> Delete</button>
                                        <button type="button" id="update-<?= $answer->id ?>" class="btn btn-primary btn-sm update" data-toggle="modal" data-target="#ex-<?= $answer->id ?>">
                                            <i class="far fa-edit"></i> Update
                                        </button>
                                    <?php endif ?>
                                <?php endif ?>
                                <?php if (Yii::$app->user->id && $answer->users_id !== Yii::$app->user->id): ?>
                                    <?php if (Users::checkVote($answer->id, Yii::$app->user->id)): ?>
                                        <!-- Social sharing buttons -->
                                        <button type="button" id="vote-<?= $answer->id ?>" class="btn btn-success btn-sm voted"><i class="far fa-thumbs-up"></i> Like</button>
                                    <?php else: ?>
                                        <!-- Social sharing buttons -->
                                        <button type="button" id="vote-<?= $answer->id ?>" class="btn btn-default btn-sm vote"><i class="far fa-thumbs-up"></i> Like</button>
                                    <?php endif ?>
                                <?php endif ?>
                                <span class="float-right text-muted"><?= $answer->likes ?> likes</span>
                                <!-- /.comment-text -->
                            </div>
                            <!-- /.card-comment -->
                        </div>
                    <?php endif ?>
                   <div id="modals-<?= $model->id ?>">
                        <?php if ($user_actually_id): ?>
                            <div class="modal fade" id="ex-<?= $answer->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- /.card-footer -->
                                            <div class="card-footer mb-3">
                                                <!-- User image -->
                                                <div class="img-fluid img-circle img-sm">
                                                    <?= $img_response ?>
                                                </div>
                                                <!-- .img-push is used to add margin to elements next to floating images -->
                                                <div class="img-push">
                                                    <input type="text" id="con-<?= $answer->id ?>" class="form-control form-control-sm" placeholder="Press enter to post comment">
                                                </div>
                                            </div>
                                            <!-- /.card-footer -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="send-<?= $answer->id ?>" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                <?php endforeach ?>
            </div>
        <?php if ($user_actually_id): ?>
            <!-- /.card-footer -->
            <div class="card-footer mb-3">
                <!-- User image -->
                <div class="img-fluid img-circle img-sm">
                    <?= $img_response ?>
                </div>
                <form action="" method="post" id="form-codemirror-<?= $model->id ?>">
                    <!-- .img-push is used to add margin to elements next to floating images -->
                    <div class="ml-5 img-push">
                        <textarea id="codemirror-<?= $model->id ?>"></textarea>
                    </div>
                    <button type="submit" name="preview-form-submit" id="preview-form-submit-<?= $model->id ?>" 
                            value="Submit" class="mt-3 float-right btn btn-success">Send reply</button>
                </form>
            </div>
            <!-- /.card-footer -->
        <?php endif ?>
    </div>
</div>
