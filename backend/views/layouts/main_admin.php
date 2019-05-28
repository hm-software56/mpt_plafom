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
        <meta http-equiv="X-Frame-Options" content="deny">
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
             
                <div class="logo">
                    <a href="<?php echo Yii::$app->urlManager->baseUrl . "/index.php?r=site/indexadmin"; ?>" class="simple-text">
                        <?= Yii::$app->params["nameProject"] . " " . Yii::t('app', 'ADMIN PANEL') ?>
                    </a>
                </div>


                <div class="sidebar-wrapper">
                    <ul class="nav" id="menu">
                        <?php if ($user->checkAccess($user->type, "/setting", "update") == 1) { ?>
                            <li><a href="<?php echo Yii::$app->urlManager->baseUrl . "/index.php?r=setting/update&id=" . Yii::$app->params["settingId"]; ?>"><i class="fa fa-gears"></i> <?= Yii::t('app', 'Update Setting') ?></a></li>
                        <?php } ?>
                        <?php if ($user->checkAccess($user->type, "/rbac", "role") == 1) { ?>
                            <li><a href="<?php echo Yii::$app->urlManager->baseUrl . "/index.php?r=rbac/role"; ?>"><i class="fa fa-dashboard fa-fw"></i> <?= Yii::t('app', 'Access Control') ?></a></li>
                        <?php } ?>
                        <?php if ($user->checkAccess($user->type, "/user", "index") == 1) { ?>
                            <li><a href="<?php echo Yii::$app->urlManager->baseUrl . "/index.php?r=user"; ?>"><i class="fa fa-user"></i> <?= Yii::t('app', 'Users') ?></a></li>
                        <?php } ?>
                        <?php if ($user->checkAccess($user->type, "/banner", "index") == 1) { ?>
                            <li><a href="<?php echo Yii::$app->urlManager->baseUrl . "/index.php?r=banner/update&id=1"; ?>"><i class="fa fa-user"></i> <?= Yii::t('app', 'Manage Banner') ?></a></li>
                        <?php } ?>
                        <?php if ($user->checkAccess($user->type, "/menu", "index") == 1) { ?>
                            <li><a href="<?php echo Yii::$app->urlManager->baseUrl . "/index.php?r=menu"; ?>"><i class="fa fa-th-list"></i>  <?= Yii::t('app', 'Menus') ?></a></li>
                        <?php } ?>
                        <?php if ($user->checkAccess($user->type, "/content-category", "index") == 1) { ?>
                            <li><a href="<?php echo Yii::$app->urlManager->baseUrl . "/index.php?r=content-category"; ?>"><i class="fa fa-book"></i> <?= Yii::t('app', 'Manage Content Categories') ?></a></li>
                        <?php } ?>
                        <?php if ($user->checkAccess($user->type, "/home", "index") == 1) { ?>
                            <li><a href="<?php echo Yii::$app->urlManager->baseUrl . "/index.php?r=home"; ?>"><i class="fa fa-book"></i> <?= Yii::t('app', 'Manage Home') ?></a></li>
                        <?php } ?>
                        <?php if ($user->checkAccess($user->type, "/content", "index") == 1) { 
                                ?>
                            <?php
                            $types = backend\models\ContentCategory::find()->localized()->where(['status' => 1])->andWhere(['is_legal_type' => 0])->orderBy(['id' => SORT_ASC])->all();
                            if (count($types) > 0) {
                                ?>
                                <?php
                              /*  $arr_type=[];
                                if($user->type=="Activation")
                                {
                                    $arr_type=[2];
                                }elseif($user->type=="Notification")
                                {
                                    $arr_type=[7];  
                                }elseif($user->type=="Admin"|| $user->type=="Superadmin"){
                                    $arr_type=[];
                                foreach ($types as $type) {
                                    $arr_type[]=$type->id;
                                }
                                }*/
                                foreach ($types as $type) {
                                  //  if (in_array($type->id,$arr_type)) {
                                        ?>
                                    <li><a href="<?php echo Yii::$app->urlManager->baseUrl . "/index.php?r=content&type=" . $type->id; ?>"><i class="fa fa-newspaper-o"></i> <?= Yii::t('app', 'Manage') . " " . $type->title; ?></a></li>
                                <?php
                                  //  }
                                } ?>
                                </li>
                            <?php } ?>
                        <?php } ?>
                        <?php if ($user->checkAccess($user->type, "/content", "index") == 1) { ?>
                            <?php
                            $types = backend\models\ContentCategory::find()->localized()->where(['status' => 1])->andWhere(['is_legal_type' => 1])->orderBy(['id' => SORT_ASC])->all();
                            if (count($types) > 0 ) {
                                
                               /* $arr2_type=[];
                                if($user->type=="Knowledgebase")
                                {
                                    $arr2_type=[14,19,20];
                                }if($user->type=="Admin" || $user->type=="Super Admin")
                                {
                                foreach ($types as $type) {
                                    $arr2_type[]=$type->id;
                                }
                                }*/
                                ?>
                                <?php
                                foreach ($types as $type) { 
                                    //if (in_array($type->id, $arr2_type)) {
                                        ?>
                                    <li><a href="<?php echo Yii::$app->urlManager->baseUrl . "/index.php?r=content&type=" . $type->id; ?>"><i class="fa fa-anchor"></i> <?= Yii::t('app', 'Manage') . " " . $type->title; ?></a></li>
                                <?php
                                  //  }
                                } ?>
                                </li>
                            <?php } ?>
                        <?php } ?>
                        <?php if ($user->checkAccess($user->type, "/gallery", "index") == 1 && $setting->has_photo) { ?>
                            <li><a href="<?php echo Yii::$app->urlManager->baseUrl . "/index.php?r=gallery"; ?>"><i class="fa fa-picture-o"></i> <?= Yii::t('app', 'Galleries') ?></a></li>
                        <?php } ?>
                        <?php if ($user->checkAccess($user->type, "/video", "index") == 1 && $setting->has_video) { ?>
                            <li><a href="<?php echo Yii::$app->urlManager->baseUrl . "/index.php?r=video"; ?>"><i class="fa fa-video-camera fa-fw"></i> <?= Yii::t('app', 'Videos') ?></a></li>
                        <?php } ?>
                        <?php if ($user->checkAccess($user->type, "/slider", "index") == 1 && $setting->has_slide) { ?>
                            <li><a href="<?php echo Yii::$app->urlManager->baseUrl . "/index.php?r=slider"; ?>"><i class="fa fa-sliders"></i> <?= Yii::t('app', 'Sliders') ?></a></li>
                        <?php } ?>
                       <!-- <?php if ($user->checkAccess($user->type, "/social-media", "index") == 1 && $setting->has_social_media) { ?>
                            <li><a href="<?php echo Yii::$app->urlManager->baseUrl . "/index.php?r=social-media"; ?>"><i class="fa fa-facebook"></i> <?= Yii::t('app', 'Manage  Sidebar') ?></a></li>
                        <?php } ?>-->
                        <?php if ($user->checkAccess($user->type, "/issue-category", "index") == 1) { ?>
                            <li><a href="<?php echo Yii::$app->urlManager->baseUrl . "/index.php?r=issue-category"; ?>"><i class="fa fa-warning"></i> <?= Yii::t('app', 'Issue Categories') ?></a></li>
                        <?php } ?>
                        <?php if ($user->checkAccess($user->type, "/issue", "index") == 1) { ?>
                            <li><a href="<?php echo Yii::$app->urlManager->baseUrl . "/index.php?r=issue"; ?>"><i class="fa fa-bug"></i> <?= Yii::t('app', 'Issues') ?></a></li>
                        <?php } ?>
                        <?php
                            if ($user->type=="Admin" || $user->type=="Super Admin") { ?>
                                <li><a href="<?php echo Yii::$app->urlManager->baseUrl . "/index.php?r=site/visiter"; ?>"><i class="fa fa-line-chart"></i> <?= Yii::t('app', 'ສະ​ຖິ​ຕີການຄົນ​ເຂົ້າຊົມເວບ') ?></a></li>
                            <?php
                            }
                        ?>
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
                                        'url' => Yii::$app->urlManager->baseUrl . "/index.php?r=site/indexadmin",
                                    ],
                                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                ])
                                ?>
                            </div>

                        </div>
                        <div class="collapse navbar-collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <?php if (count(Yii::$app->params['languages']) > 1) { ?>
                                    <li>
                                        <?= Html::a('<i class="fa fa-globe"></i> ' .Yii::t('app','Source Code Translations'), ['/i18n']) ?>
                                    </li>
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