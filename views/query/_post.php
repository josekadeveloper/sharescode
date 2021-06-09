<?php

use app\models\Answer;
use app\models\Portrait;
use app\models\Query;
use app\models\Users;
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerJsFile('@web/js/codemirror.js', ['position' => $this::POS_END]);
$this->registerJsFile('@web/mode/javascript.js', ['position' => $this::POS_END]);
$this->registerCssFile('@web/css/codemirror.css', ['position' => $this::POS_HEAD]);
$this->registerCssFile('@web/theme/abbott.css', ['position' => $this::POS_HEAD]);
$this->registerCssFile('@web/theme/ambiance.css', ['position' => $this::POS_HEAD]);
$this->registerCssFile('@web/theme/cobalt.css', ['position' => $this::POS_HEAD]);
$this->registerCssFile('@web/theme/dracula.css', ['position' => $this::POS_HEAD]);
$this->registerCssFile('@web/theme/eclipse.css', ['position' => $this::POS_HEAD]);
$this->registerCssFile('@web/theme/elegant.css', ['position' => $this::POS_HEAD]);
$this->registerCssFile('@web/theme/isotope.css', ['position' => $this::POS_HEAD]);
$this->registerCssFile('@web/theme/lucario.css', ['position' => $this::POS_HEAD]);
$this->registerCssFile('@web/theme/material.css', ['position' => $this::POS_HEAD]);
$this->registerCssFile('@web/theme/neo.css', ['position' => $this::POS_HEAD]);
$this->registerCssFile('@web/theme/night.css', ['position' => $this::POS_HEAD]);
$this->registerCssFile('@web/theme/oceanic-next.css', ['position' => $this::POS_HEAD]);
$this->registerCssFile('@web/theme/the-matrix.css', ['position' => $this::POS_HEAD]);
$this->registerCssFile('@web/theme/yeti.css', ['position' => $this::POS_HEAD]);

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
$url_like = Url::to(['answer/like']);
$url_dislike = Url::to(['answer/dislike']);
$createAnswer = <<<EOT
    var cm = CodeMirror.fromTextArea(document.getElementById("codemirror-$model->id", {}));
    cm.setOption("theme", "abbott");
    $('#select-$model->id').change(function(){
        $('#form-codemirror-$model->id .cm-s-default').fadeOut('fast', function() {
            $('#form-codemirror-$model->id .cm-s-default').remove();
        });

        if ($('#form-codemirror-$model->id .img-push').children()[1] != undefined) {
            $('#form-codemirror-$model->id .img-push').children()[1].remove();
        }

        let cm = CodeMirror.fromTextArea(document.getElementById("codemirror-$model->id", {}));
        
        if (screen.width < 1024) {
            cm.setSize(480, 300);
            if (screen.width < 400) {
                cm.setSize(280, 300);
            }
        } else {
            if (screen.width < 1280) {
                cm.setSize(630, 300);
            } 
            if (screen.width > 1280) {
                cm.setSize(730, 300);
            }
            if (screen.width >= 1920) {
                cm.setSize(1070, 300);
            }
        }
        var modeInput = document.getElementById("select-$model->id")
        var index  = modeInput.selectedIndex;
        let theme = modeInput.options[index].text.toLowerCase();
        cm.setOption("theme", theme);
    });

    $('#form-codemirror-$model->id').submit(function (ev) {
        ev.preventDefault();
        var content = $('#form-codemirror-$model->id .CodeMirror-lines')[0].innerText;

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

                var cmd = CodeMirror.fromTextArea(document.getElementById("codemirror-modal-"+id, {}));
                cmd.setOption("theme", "abbott");

                $('#select-modal-'+id).change(function(){
                    if ($('#form-codemirror-modal-'+id).find('.img-push').children()[1] != undefined) {
                        $('#form-codemirror-modal-'+id).find('.img-push').children()[1].remove();
                    }     
                    let cmd = CodeMirror.fromTextArea(document.getElementById("codemirror-modal-"+id, {}));

                    cmd.setSize(380, 300);
                    
                    var modeInput = document.getElementById("select-modal-"+id)
                    var index  = modeInput.selectedIndex;
                    let theme = modeInput.options[index].text.toLowerCase();
                    cmd.setOption("theme", theme);
                });
                
                $('#form-codemirror-modal-'+id).submit(function (ev) {
                    var content = $('#form-codemirror-modal-'+id).find('.CodeMirror-lines')[0].innerText;
                    
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

            var cmd = CodeMirror.fromTextArea(document.getElementById("codemirror-modal-"+id, {}));
            cmd.setOption("theme", "abbott");

            $('#select-modal-'+id).change(function(){
                if ($('#form-codemirror-modal-'+id).find('.img-push').children()[1] != undefined) {
                    $('#form-codemirror-modal-'+id).find('.img-push').children()[1].remove();
                }     
                let cmd = CodeMirror.fromTextArea(document.getElementById("codemirror-modal-"+id, {}));

                cmd.setSize(380, 300);
                
                var modeInput = document.getElementById("select-modal-"+id)
                var index  = modeInput.selectedIndex;
                let theme = modeInput.options[index].text.toLowerCase();
                cmd.setOption("theme", theme);
            });
            
            $('#form-codemirror-modal-'+id).submit(function (ev) {
                var content = $('#form-codemirror-modal-'+id).find('.CodeMirror-lines')[0].innerText;
                
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

                    $('.card-comment').on('click', '#delete-' + data.answer_id, function() {
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

$likeAnswer = <<<EOT
    var list = [];
    $(".like").each(function(index) {
        list.push($(this).attr("id"));
    });

    $.each(list, function (ind, elem) {
        $('#'+elem).click(function (ev) {
            ev.preventDefault();
            var id = elem.substring(5);

            $.ajax({
                type: 'POST',
                url: '$url_like',
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
  
                let father_id = $('#like-'+answer_id).parent().parent().parent().attr("id");
                $('#'+father_id).append(newAnswer);
                newAnswer.fadeIn('fast');

                $('.card-comment').on('click', '#dislike-' + data.answer_id, function() {
                    $.ajax({
                        type: 'POST',
                        url: '$url_dislike',
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
          
                        let father_id = $('#dislike-'+answer_id).parent().parent().parent().attr("id");
                        $('#'+father_id).append(newAnswer);
                        newAnswer.fadeIn('fast');
                        location.reload();
                    });
                    return false;
                });
            });
            return false;
        });
    });
EOT;

$dislikeAnswer = <<<EOT
    var list = [];
    $(".dislike").each(function(index) {
        list.push($(this).attr("id"));
    });

    $.each(list, function (ind, elem) {
        $('#'+elem).click(function (ev) {
            ev.preventDefault();
            var id = elem.substring(8);

            $.ajax({
                type: 'POST',
                url: '$url_dislike',
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
  
                let father_id = $('#dislike-'+answer_id).parent().parent().parent().attr("id");
                $('#'+father_id).append(newAnswer);
                newAnswer.fadeIn('fast');

                $('.card-comment').on('click', '#like-' + data.answer_id, function() {
                    $.ajax({
                        type: 'POST',
                        url: '$url_like',
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
          
                        let father_id = $('#like-'+answer_id).parent().parent().parent().attr("id");
                        $('#'+father_id).append(newAnswer);
                        newAnswer.fadeIn('fast');
                        location.reload();
                    });
                    return false;
                });
            });
            return false;
        });
    });
EOT;

if (!Yii::$app->user->isGuest) {
    $this->registerJs($createAnswer);
    $this->registerJs($deleteAnswer);
    $this->registerJs($updateAnswer);
    $this->registerJs($likeAnswer);
    $this->registerJs($dislikeAnswer);
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
                <?php if ($model->users_id === Yii::$app->user->id || Yii::$app->user->identity->is_admin === true): ?>
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
                                <?php if (!Yii::$app->user->isGuest): ?>
                                    <?php if ($answer->users_id === Yii::$app->user->id || Yii::$app->user->identity->is_admin === true): ?>
                                        <!-- Delete or update answer -->
                                        <button type="button" id="delete-<?= $answer->id ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-minus-circle"></i> Delete</button>
                                        <button type="button" id="update-<?= $answer->id ?>" class="btn btn-primary btn-sm update" data-toggle="modal" data-target="#ex-<?= $answer->id ?>">
                                            <i class="far fa-edit"></i> Update
                                        </button>
                                    <?php endif ?>
                                    <?php if (Yii::$app->user->id && $answer->users_id !== Yii::$app->user->id): ?>
                                        <?php if (Users::checkLike($answer->id, Yii::$app->user->id)): ?>
                                            <!-- Social sharing buttons -->
                                            <button type="button" id="like-<?= $answer->id ?>" class="btn btn-success btn-sm liked"><i class="far fa-thumbs-up"></i> Like</button>
                                            <button type="button" id="dislike-<?= $answer->id ?>" class="btn btn-default btn-sm dislike"><i class="far fa-thumbs-down"></i> Dislike</button>
                                        <?php elseif (Users::checkDislike($answer->id, Yii::$app->user->id)): ?>
                                            <!-- Social sharing buttons -->
                                            <button type="button" id="like-<?= $answer->id ?>" class="btn btn-default btn-sm like"><i class="far fa-thumbs-up"></i> Like</button>
                                            <button type="button" id="dislike-<?= $answer->id ?>" class="btn btn-danger btn-sm disliked"><i class="far fa-thumbs-down"></i> Dislike</button>
                                        <?php else: ?>
                                            <!-- Social sharing buttons -->
                                            <button type="button" id="like-<?= $answer->id ?>" class="btn btn-default btn-sm like"><i class="far fa-thumbs-up"></i> Like</button>
                                            <button type="button" id="dislike-<?= $answer->id ?>" class="btn btn-default btn-sm dislike"><i class="far fa-thumbs-down"></i> Dislike</button>
                                        <?php endif ?>
                                    <?php endif ?>
                                <?php endif ?>
                                <i id="icon-check" class="ml-2 float-right fas fa-check"></i>
                                <span class="float-right text-muted"><?= $answer->likes ?> likes - <?= $answer->dislikes ?> dislikes</span>
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
                                    <?php if ($answer->users_id === Yii::$app->user->id || Yii::$app->user->identity->is_admin === true): ?>
                                        <!-- Delete or update answer -->
                                        <button type="button" id="delete-<?= $answer->id ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-minus-circle"></i> Delete</button>
                                        <button type="button" id="update-<?= $answer->id ?>" class="btn btn-primary btn-sm update" data-toggle="modal" data-target="#ex-<?= $answer->id ?>">
                                            <i class="far fa-edit"></i> Update
                                        </button>
                                    <?php endif ?>
                                    <?php if (Yii::$app->user->id && $answer->users_id !== Yii::$app->user->id): ?>
                                        <?php if (Users::checkLike($answer->id, Yii::$app->user->id)): ?>
                                            <!-- Social sharing buttons -->
                                            <button type="button" id="like-<?= $answer->id ?>" class="btn btn-success btn-sm liked"><i class="far fa-thumbs-up"></i> Like</button>
                                            <button type="button" id="dislike-<?= $answer->id ?>" class="btn btn-default btn-sm dislike"><i class="far fa-thumbs-down"></i> Dislike</button>
                                        <?php elseif (Users::checkDislike($answer->id, Yii::$app->user->id)): ?>
                                            <!-- Social sharing buttons -->
                                            <button type="button" id="like-<?= $answer->id ?>" class="btn btn-default btn-sm like"><i class="far fa-thumbs-up"></i> Like</button>
                                            <button type="button" id="dislike-<?= $answer->id ?>" class="btn btn-danger btn-sm disliked"><i class="far fa-thumbs-down"></i> Dislike</button>
                                        <?php else: ?>
                                            <!-- Social sharing buttons -->
                                            <button type="button" id="like-<?= $answer->id ?>" class="btn btn-default btn-sm like"><i class="far fa-thumbs-up"></i> Like</button>
                                            <button type="button" id="dislike-<?= $answer->id ?>" class="btn btn-default btn-sm dislike"><i class="far fa-thumbs-down"></i> Dislike</button>
                                        <?php endif ?>
                                    <?php endif ?>
                                <?php endif ?>
                                <span class="float-right text-muted"><?= $answer->likes ?> likes - <?= $answer->dislikes ?> dislikes</span>
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
                                                <form action="<?= $url_update ?>" method="post">
                                                    <div class="mb-5 ml-5 form-group">
                                                        <label for="select-modal-<?= $answer->id ?>">Select a theme: </label>
                                                        <select class="form-control" name="theme" id="select-modal-<?= $answer->id ?>">
                                                            <option value="1">abbott</option>
                                                            <option value="2">ambiance</option>
                                                            <option value="3">cobalt</option>
                                                            <option value="4">dracula</option>
                                                            <option value="5">eclipse</option>
                                                            <option value="6">elegant</option>
                                                            <option value="7">isotope</option>
                                                            <option value="8">lucario</option>
                                                            <option value="9">material</option>
                                                            <option value="10">neo</option>
                                                            <option value="11">night</option>
                                                            <option value="12">oceanic-next</option>
                                                            <option value="13">the-matrix</option>
                                                            <option value="14">yeti</option>
                                                        </select>
                                                    </div>
                                                </form>
                                                <!-- User image -->
                                                <div class="img-fluid img-circle img-sm">
                                                    <?= $img_response ?>
                                                </div>
                                                <form action="" method="post" id="form-codemirror-modal-<?= $answer->id ?>">
                                                    <!-- .img-push is used to add margin to elements next to floating images -->
                                                    <div class="ml-5 img-push">
                                                        <textarea id="codemirror-modal-<?= $answer->id ?>"></textarea>
                                                    </div>
                                                    <button type="submit" name="preview-form-submit-modal" id="preview-form-submit-modal-<?= $answer->id ?>" 
                                                            value="Submit" class="mt-3 float-right btn btn-success">Send reply</button>
                                                </form>
                                            </div>
                                            <!-- /.card-footer -->
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
                <form action="" method="post">
                    <div class="mb-5 ml-5 form-group">
                        <label for="select-<?= $model->id ?>">Select a theme: </label>
                        <select class="form-control" name="theme" id="select-<?= $model->id ?>">
                            <option value="1">abbott</option>
                            <option value="2">ambiance</option>
                            <option value="3">cobalt</option>
                            <option value="4">dracula</option>
                            <option value="5">eclipse</option>
                            <option value="6">elegant</option>
                            <option value="7">isotope</option>
                            <option value="8">lucario</option>
                            <option value="9">material</option>
                            <option value="10">neo</option>
                            <option value="11">night</option>
                            <option value="12">oceanic-next</option>
                            <option value="13">the-matrix</option>
                            <option value="14">yeti</option>
                        </select>
                    </div>
                </form>
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
