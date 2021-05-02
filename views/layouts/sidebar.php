<?php

use yii\helpers\Html;

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed">
    <!-- Brand Logo -->
    <a href=<?= Yii::$app->homeUrl ?> class="brand-link">
        <?= Html::img('@web/img/sharecode.svg', ['class'=> 'brand-image img-circle mt-1'], ['style' => 'opacity: .8' ]) ?>
        <span class="brand-text font-weight-light"><?= Yii::$app->name ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu Users -->
        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->is_admin === false):?>
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <?= $img ?>
                    </div>
                    <div class="info">
                        <a href=<?= $urlPortrait ?> class="d-block"><?= $nickname ?></a>
                    </div>
                </div>
            <nav class="mt-2">
                <?php
                echo \hail812\adminlte3\widgets\Menu::widget([
                    'items' => [
                        [
                            'label' => 'Prestigie',
                            'icon' => 'fas fa-medal',
                            'badge' => '<span class="right badge badge-info">' . $prestigie .  '</span>',
                        ],
                        ['label' => 'Create Query', 'icon' => 'fas fa-question-circle', 'url' => ['query/create'], 
                                                    'badge' => '<span class="right badge badge-success">New</span>'],
                        ['label' => 'Answers List', 'icon' => 'fad fa-reply-all', 'url' => ['answer/index']],
                    ],
                ]);
                ?>
            </nav>
        <?php endif ?>
        <!-- /.sidebar-menu-users -->

        <!-- Sidebar Menu Guest -->
        <?php if (Yii::$app->user->isGuest):?>
            <nav class="mt-2">
                <?php
                echo \hail812\adminlte3\widgets\Menu::widget([
                    'items' => [
                        [
                            'label' => 'DEAR GUEST',
                            'icon' => 'fas fa-smile-beam',
                            'badge' => '<span class="left badge badge-primary">Welcome to ShareCode</span>',
                        ],
                        ['label' => 'LOGIN', 'header' => true],
                        ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt'],
                    ],
                ]);
                ?>
            </nav>
        <?php endif ?>
        <!-- /.sidebar-menu-guest -->

                <!-- Sidebar Menu Admin -->
                <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->is_admin === true):?>
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <?= $img ?>
                    </div>
                    <div class="info">
                        <a href=<?= $urlPortrait ?> class="d-block"><?= $nickname ?></a>
                    </div>
                </div>
            <nav class="mt-2">
                <?php
                echo \hail812\adminlte3\widgets\Menu::widget([
                    'items' => [
                        ['label' => 'USER OPTIONS', 'header' => true],
                        ['label' => 'Users Lists', 'icon' => 'fas fa-users', 'url' => ['users/index']],
                        ['label' => 'Create Users', 'icon' => 'fas fa-user-plus', 'url' => ['users/create'], 
                                                    'badge' => '<span class="right badge badge-success">New</span>'],
                        ['label' => 'Create Query', 'icon' => 'fas fa-question-circle', 'url' => ['query/create'], 
                                                    'badge' => '<span class="right badge badge-success">New</span>'],
                        ['label' => 'Answers List', 'icon' => 'fad fa-reply-all', 'url' => ['answer/index']],
                        ['label' => 'APP DEBUGER', 'header' => true],
                        ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],
                    ],
                ]);
                ?>
            </nav>
        <?php endif ?>
        <!-- /.sidebar-menu-admin -->
    </div>
    <!-- /.sidebar -->
</aside>