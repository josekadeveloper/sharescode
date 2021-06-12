<?php

use yii\helpers\Html;

?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?=\yii\helpers\Url::home()?>" class="nav-link">Home</a>
        </li>
        <?php if (Yii::$app->user->isGuest): ?>
            <li class="nav-item d-none d-sm-inline-block">
                    <?= Html::a('Register', ['portrait/register'], ['class' => 'nav-link']) ?>
            </li>
        <?php endif ?>
        <?php if (!Yii::$app->user->isGuest): ?>
            <li class="nav-item d-none d-sm-inline-block">
                    <?= Html::a('My Portrait', ['/portrait/view', 'id' => Yii::$app->user->id], ['class' => 'nav-link']) ?>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                    <?= Html::a('Users Profiles', ['portrait/index'], ['class' => 'nav-link']) ?>
            </li>
        <?php endif ?>
        <li class="nav-item d-none d-sm-inline-block">
            <?= Html::a('Contact', ['site/contact'], ['class' => 'nav-link']) ?>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <div id="notifications">
            <li class="nav-item dropdown">
            <?php if (!Yii::$app->user->isGuest): ?>
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <?php if ($notifications_no_read !== 0): ?>
                        <span class="badge badge-warning navbar-badge"><?= $notifications_no_read ?></span>
                    <?php endif ?>
                </a>
            <?php endif ?>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header"><?= $notifications_no_read ?> Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href=<?= $urlReminder ?> class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i><?= $notifications_no_read ?> new answers
                        <span class="float-right text-muted text-sm"><?= $notifications_time ?></span>
                    </a>
                </div>
            </li>
        </div>
        <?php if (!Yii::$app->user->isGuest): ?>
            <li class="nav-item">
                <?= Html::a('<i class="fas fa-sign-out-alt"></i>', ['/site/logout'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
            </li>
        <?php else: ?>
            <li class="nav-item">
                <?= Html::a('<i class="fas fa-sign-in-alt"></i>', ['/site/login'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
            </li>
        <?php endif ?>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->