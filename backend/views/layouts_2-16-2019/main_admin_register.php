<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAssetAdmin;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use kartik\alert\Alert;

AppAssetAdmin::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode(Yii::$app->name) ?></title>
        <?php $this->head() ?>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo Yii::$app->urlManager->baseUrl . '/font-awesome/css/font-awesome.css' ?>"/>
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?php echo Yii::$app->urlManager->baseUrl . '/font-awesome/css/ionicons.css' ?>"/>
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
        <link rel = "stylesheet" href="<?php echo Yii::$app->urlManager->baseUrl . '/css/admin.css' ?>"/>
        <?php foreach (Yii::$app->params['languages'] as $language => $value) { ?>
            <?php
            if (Yii::$app->language == $language && Yii::$app->language != "en") {
                ?>
                <link rel = "stylesheet" href="<?php echo Yii::$app->urlManager->baseUrl . '/css/admin_' . $language . '.css' ?>"/>
                <?php
            }
            ?>
        <?php } ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <?php
        if (!isset(Yii::$app->session["currentUser"])) {
            $session = new \yii\web\Session;
            $session->open();
        }
        $user = \backend\models\User::findOne(['id' => \Yii::$app->user->id]);
        Yii::$app->session["currentUser"] = $user;

        $setting = \backend\models\Setting::findOne(Yii::$app->params["settingId"]);
        if (isset($setting)) {
            if (!isset(Yii::$app->session["setting"])) {
                $session = new \yii\web\Session;
                $session->open();
            }
            Yii::$app->session["setting"] = $setting;
        }
        ?>
        <div class="wrapper">
            <div class="sidebar" data-color="blue" data-image="<?php echo Yii::$app->urlManager->baseUrl . '/admin-theme/assets/img/sidebar-1.jpg'; ?>">
                <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"
            Tip 2: you can also add an image using data-image tag

                -->

                <div class="logo">
                    <a href="<?php echo Yii::$app->urlManager->baseUrl . "/index.php?r=event/event"; ?>" class="simple-text">
                        <?= Yii::t('app','Meeting'). " " . Yii::t('app', 'ADMIN PANEL') ?>
                    </a>
                </div>


                <div class="sidebar-wrapper">
                    <ul class="nav" id="menu">
                        <?php
                        $user = \backend\models\User::findOne(['id' => \Yii::$app->user->id]);
                        if($user->type!="Register")
                        {
                        ?>
                        <li><a href="<?php echo Yii::$app->urlManager->baseUrl . "/index.php?r=user/usermeeting"; ?>"><i class="fa fa-flag"></i> <?= Yii::t('app', 'Manage User') ?></a></li>
                        <?php
                        }
                        ?>
                        <li><a href="<?php echo Yii::$app->urlManager->baseUrl . "/index.php?r=event/event"; ?>"><i class="fa fa-flag"></i> <?= Yii::t('app', 'Manage Registration') ?></a></li>
                    </ul>  
                </div>
            </div>

            <div class="main-panel">
                <nav class="navbar navbar-transparent navbar-absolute">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <div class="pull-left" style="padding:20px;">
                                <?=
                                Breadcrumbs::widget(['homeLink' => [
                                        'label' => Yii::t('app', 'Home'),
                                        'url' => Yii::$app->urlManager->baseUrl . "/index.php?r=event/event",
                                    ],
                                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                ])
                                ?>
                            </div>

                        </div>
                        <div class="collapse navbar-collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <?php if (count(Yii::$app->params['languages']) > 1) { ?>
                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                            <i class="fa fa-language"></i> <i class="fa fa-caret-down"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <?php foreach (Yii::$app->params['languages'] as $language => $value) { ?>
                                                <li>
                                                    <?= Html::a('<i class="fa fa-language"></i> ' . $value, Url::toRoute(['site/language', 'lang' => $value]), ['title' => $value]) ?>
                                                </li>
                                                <li class="divider"></li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-user">
                                        <li>
                                            <a href="<?php echo Yii::$app->urlManager->baseUrl . "/index.php?r=site/changepassword"; ?>"><i class="fa fa-user fa-fw"></i> <?= Yii::t('app', 'Change Password'); ?></a>
                                        </li>

                                        <li class="divider"></li>
                                        <li>
                                            <?php
                                            echo Html::a((Yii::$app->user->identity) ? '<i class="fa fa-sign-out fa-fw"></i> ' . Yii::t('app', 'Logout') :
                                                    '<i class="fa fa-sign-in fa-fw"></i> ' . Yii::t('app', 'Login'), [(Yii::$app->user->identity) ? '//site/logout' : '//site/login'], ['data-method' => 'post']
                                            );
                                            ?>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header" style="background-color:#062A5A !important;">
                                        <h4 class="title"><?= $this->title; ?></h4>
                                    </div>
                                    <div class="card-content table-responsive">
                                        <?php
                                        if (Yii::$app->session->hasFlash('success')) {
                                            echo Alert::widget([
                                                'type' => Alert::TYPE_SUCCESS,
                                                'title' => '',
                                                'icon' => 'glyphicon glyphicon-ok',
                                                'body' => Yii::t('app', Yii::$app->session->getFlash('success')),
                                                'showSeparator' => false,
                                                'delay' => 20000
                                            ]);
                                        } else if (Yii::$app->session->hasFlash('error')) {
                                            echo Alert::widget([
                                                'type' => Alert::TYPE_DANGER,
                                                'title' => '',
                                                'icon' => 'glyphicon glyphicon-remove',
                                                'body' => Yii::t('app', Yii::$app->session->getFlash('error')),
                                                'showSeparator' => false,
                                                'delay' => 20000
                                            ]);
                                        }
                                        ?>
                                        <?php echo preg_replace("/\xEF\xBB\xBF/", "", $content); ?>

                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <footer class="footer">
                    <div class="container-fluid">

                        <p class="copyright pull-right">
                            &copy; <script>document.write(new Date().getFullYear())</script> <a href="http://www.http://cyberia.la/">Cyberia</a>, All rights reserved
                        </p>
                    </div>
                </footer>
            </div>
        </div>
        <!-- /#wrapper -->

        <?php $this->endBody() ?>
        <script>
            $(document).ready(function () {
                $('.dropdown').hover(function () {
                    $(this).find('.dropdown-menu').first().stop(true, true).slideDown(150);
                }, function () {
                    $(this).find('.dropdown-menu').first().stop(true, true).slideUp(105)
                });
                $('#detail-modal').on('shown.bs.modal', function (e) {
                    $('.main-panel').css('zIndex', '999999');
                });

                $('#detail-modal').on('hidden.bs.modal', function (e) {
                    $('.main-panel').css('zIndex', '3');
                });
                var url = window.location.href;
                $('#menu a').each(function () {
                    if (url == this.href) {
                        $(this).addClass('active');
                        if ($(this).parent("li")) {
                            $(this).parent("li").addClass('active');
                        }
                        if ($(this).parent().parent("li")) {
                            $(this).parent().parent("li").addClass('active');
                        }
                        if ($(this).parent().parent().parent("li")) {
                            $(this).parent().parent().parent("li").addClass('active');
                        }
                        if ($(this).parent().parent().parent().parent("li")) {
                            $(this).parent().parent().parent().parent("li").addClass('active');
                        }
                    }
                });
            });
        </script>
        <script>
            $(window).load(function()
            {
                $('#myModal').modal('show');
            });
        </script>
    </body>
</html>
<?php $this->endPage() ?>