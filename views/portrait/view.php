<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->registerJsFile('https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js', ['position' => $this::POS_END]);

$date = new DateTime($model->date_register);
$date = $date->format('d-m-Y H:i:s');

$js = <<<EOT
    var firstTable = new Vue({
        el: '#firstTable',
        data: {
          rows: [
            { 
              nickname: '$model->nickname', 
              date_register: '$date', 
              email: '$model->email',
              repository: '$model->repository', 
              prestige_port: '$model->prestige_port', 
              sex: '$model->sex',
            },
          ]
        }
      });
EOT;
$this->registerJs($js);

$url_prestige = Url::to(['/prestige/view', 'id' => $model->id]);
?>
<div class="row justify-content-center">
    <div class="portrait-view formulario col-md-6" style="margin-bottom: 2.7vw;">
    <?php if (Yii::$app->user->id): ?>
        <?php if ($model->id == $user_id || $model_portrait->is_admin === true): ?>
            <p>
                <?= Html::a('', ['update', 'id' => $model->id], ['class' => 'fas fa-user-edit btn-sm btn-primary']) ?>
                <?= Html::a('', ['delete', 'id' => $model->id], [
                    'class' => 'fas fa-trash-alt btn-sm btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete your Portrait?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        <?php endif ?>
    <?php endif ?>
        <p id="img-portrait">
            <?= $img = $model->devolverImg($model) ?>
        </p>
        <table id="firstTable">
            <tbody v-for="row in rows">
                <tr>
                    <td class="title">Nickname</td>
                    <td>{{row.nickname}}</td>
                </tr>
                <tr>
                    <td class="title">Date Register</td>
                    <td>{{row.date_register}}</td>
                </tr>
                <tr>
                    <td class="title">E-mail</td>
                    <td>{{row.email}}</td>
                </tr>
                <tr>
                    <td class="title">Repository</td>
                    <td>{{row.repository}}</td>
                </tr>
                <tr>
                    <td class="title">Prestige Port</td>
                    <td><a href="<?= $url_prestige ?>">{{row.prestige_port}}</a></td>
                </tr>
                <tr>
                    <td class="title">Sex</td>
                    <td>{{row.sex}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>