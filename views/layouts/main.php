<?php

use app\models\Users;
use yii\helpers\Html;
use yii\helpers\Url;

\hail812\adminlte3\assets\FontAwesomeAsset::register($this);
\hail812\adminlte3\assets\AdminLteAsset::register($this);

$this->registerCssFile('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback');
$this->registerCssFile('@web/css/site.css');

$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
$urlReminder = Url::to(['reminder/index']);
$notifications_no_read = Users::countReminders();
$notifications_time = Users::timeReminders();
$urlPortrait = Url::to(['/portrait/view', 'id' => Yii::$app->user->id]);
$img = Users::getImg();
$nickname = Users::getNickname();
$prestige = Users::getPrestige();
$prestige_id = Users::getPrestigeId($prestige);
$urlPrestige = Url::to(['/prestige/view', 'id' => $prestige_id]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition sidebar-mini">
<?php $this->beginBody() ?>

<div class="wrapper">
    <!-- Navbar -->
    <?= $this->render('navbar', [
        'assetDir' => $assetDir,
        'urlReminder' => $urlReminder,
        'notifications_no_read' => $notifications_no_read,
        'notifications_time' => $notifications_time,
        ]) ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?= $this->render('sidebar', [
        'assetDir' => $assetDir,
        'urlPortrait' => $urlPortrait,
        'nickname' => $nickname,
        'img' => $img,
        'prestigie' => $prestige,
        'urlPrestige' => $urlPrestige,
        ]) ?>

    <!-- Content Wrapper. Contains page content -->
    <?= $this->render('content', ['content' => $content, 'assetDir' => $assetDir]) ?>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <?= $this->render('control-sidebar') ?>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?= $this->render('footer') ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
