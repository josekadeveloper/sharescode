<?php

use yii\helpers\Html;

?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button" alt="pushmenu"><em class="fas fa-bars"></em></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?=\yii\helpers\Url::home()?>" class="nav-link">Home</a>
        </li>
        <?php if (Yii::$app->user->isGuest): ?>
            <li class="nav-item d-none d-sm-inline-block">
                    <?= Html::a('Register', ['portrait/register'], ['class' => 'nav-link', 'alt' => 'register']) ?>
            </li>
        <?php endif ?>
        <?php if (!Yii::$app->user->isGuest): ?>
            <li class="nav-item d-none d-sm-inline-block">
                    <?= Html::a('My Portrait', ['/portrait/view', 'id' => Yii::$app->user->id], ['class' => 'nav-link', 'alt' => 'yourportrait']) ?>
            </li>
        <?php endif ?>
        <li class="nav-item d-none d-sm-inline-block">
            <?= Html::a('Contact', ['site/contact'], ['class' => 'nav-link', 'alt' => 'contact']) ?>
        </li>
    </ul>

    <!-- Notifications Dropdown Menu -->
    <div id="notifications">
        <ul class="navbar-nav mr-5">
            <li class="nav-item dropdown">
            <?php if (!Yii::$app->user->isGuest): ?>
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <em class="far fa-bell"></em>
                    <?php if ($notifications_no_read !== 0): ?>
                        <span class="badge badge-warning navbar-badge"><?= $notifications_no_read ?></span>
                    <?php endif ?>
                </a>
            <?php endif ?>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header"><?= $notifications_no_read ?> Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="<?= $urlReminder ?>" class="dropdown-item">
                        <em class="fas fa-envelope mr-2"></em><?= $notifications_no_read ?> new answers
                        <span class="float-right text-muted text-sm"><?= $notifications_time ?></span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <?php if (!Yii::$app->user->isGuest): ?>
            <li class="nav-item">
                <?= Html::a('<em class="fas fa-sign-out-alt"></em>', ['/site/logout'], ['data-method' => 'post', 'class' => 'nav-link', 'alt' => 'logout']) ?>
            </li>
        <?php else: ?>
            <li class="nav-item">
                <?= Html::a('<em class="fas fa-sign-in-alt"></em>', ['/site/login'], ['data-method' => 'post', 'class' => 'nav-link', 'alt' => 'login']) ?>
            </li>
        <?php endif ?>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button" alt="fullscreen">
                <em class="fas fa-expand-arrows-alt"></em>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->