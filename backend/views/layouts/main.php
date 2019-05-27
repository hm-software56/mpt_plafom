<?php
/* @var $this \yii\web\View */
/* @var $content_menu string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use kartik\alert\Alert;
use bigpaulie\social\share\Share;
use yii\widgets\LinkPager;
use yii\data\Pagination;
use backend\models\SocialMedia;
use common\models\LoginForm;
use yii\widgets\ActiveForm;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-Frame-Options" content="deny">

        <?= Html::csrfMetaTags() ?>
        <title><?php echo Yii::t("app", "MPT"); ?>-<?= Html::encode($this->title) ?></title>
        <!-- Global Site Tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-107861244-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'UA-107861244-1');
        </script>
        <?php $this->head() ?>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo Yii::$app->urlManager->baseUrl . '/font-awesome/css/font-awesome.css' ?>">
        <link rel = "stylesheet" href="<?php echo Yii::$app->urlManager->baseUrl . '/css/site.css' ?>"/>
        <?php foreach (Yii::$app->params['languages'] as $language => $value) { ?>
            <?php
            if (Yii::$app->language == $language && Yii::$app->language != "en") {
                ?>
                <link rel = "stylesheet" href="<?php echo Yii::$app->urlManager->baseUrl . '/css/site_' . $language . '.css' ?>"/>
                <?php
            }
            ?>
        <?php } ?>


    </head>
    <body>
        <?php $this->beginBody()
        ?>
        <!-- SCROLL TOP BUTTON -->
        <a class="scrollToTop" href="#"><i class="fa fa-chevron-up"></i></a>
        <!-- END SCROLL TOP BUTTON -->
            <div class="visible-xs" style="position:absolute;top:20px;  right:5%;float:right;">
                 <a href="<?= Yii::$app->urlManager->baseUrl . "/index.php?r=site/language&lang=Lao" ?>"><img src="<?= Yii::$app->urlManager->baseUrl . '/images/la.jpg' ?>" style="width:20px; height: 20px; border-radius: 50%;" title="<?= Yii::t("app", "Lao") ?>"/></a>
                <a href="<?= Yii::$app->urlManager->baseUrl . "/index.php?r=site/language&lang=English" ?>"><img src="<?= Yii::$app->urlManager->baseUrl . '/images/en.jpg' ?>" style="width:20px; height: 20px; border-radius: 50%;" title="<?= Yii::t("app", "English") ?>"/></a>
            </div>
            <?php if (isset(Yii::$app->user->id)) { ?>
                <div style="position:absolute;top:30px; left:7%;float:left;background: #5588D9;padding:2px 5px;" class="btn btn-primary hidden-sm hidden-xs visible-lg visible-md">
                    <a href="<?= Yii::$app->urlManager->baseUrl . "/index.php?r=site/indexadmin" ?>" style="color:white;font-weight: bold;"><?= Yii::t("app", "Admin Panel") ?></a>
                </div>
                <div style="position:absolute;top:7px; left:7%;float:left;background: #5588D9;padding:2px 5px;" class="btn btn-primary visible-sm visible-xs hidden-lg hidden-md">
                    <a href="<?= Yii::$app->urlManager->baseUrl . "/index.php?r=site/indexadmin" ?>" style="color:white;font-weight: bold;"><?= Yii::t("app", "Admin Panel") ?></a>
                </div>
            <?php } ?>
            <img class="banner img-responsive" src="<?php echo Yii::$app->urlManager->baseUrl . "/"; ?>images/<?php echo Yii::$app->params["banner"]; ?>" style="width:100%;height:auto;"/>
        </div>

        <!-- Start header section -->
        <section id="menu">
            <div class="container">
                <div class="menu-area">
                    <!-- Navbar -->
                    <div class="navbar navbar-default" role="navigation">
                        <div class="navbar-header">
                            <div style="float:left;margin-top:5px;" class="visible-xs"><form method="post" role="search" action="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=site/search" >
                                    <input type="text" name="search" id="" placeholder="<?php echo Yii::t("app", "Search") ?>" class="form-control input-search" style="padding-left:5px;width: 78% !important;">
                                    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
                                    <button type="submit" class="btn-search" style="width: 10% !important;float:left;"><span class="fa fa-search"></span></button>
                                </form>
                            </div>
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>

                        </div>
                        <div class="navbar-collapse collapse">
                            <!-- Left nav -->
                            <ul class="nav navbar-nav floatright" id="topmenu">
                                <?php
                                    $menus = backend\models\Menu::find()->localized()->where(['is', 'menu_id', NULL])->andWhere(['top' => 1])->andWhere(['status' => 1])->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->all();
                                foreach ($menus as $menu) {
                                    $link = "index.php?r=site/index";
                                    if (substr($menu->link, 0, 4) == 'http') {
                                        $link = $menu->link;
                                    } else {
                                        if (isset($menu->content_id)) {
                                            $link = Yii::$app->urlManager->baseUrl . '/index.php?r=site/detail&id=' . $menu->content_id;
                                        } else if (isset($menu->link) && !empty($menu->link)) {
                                            $link = Yii::$app->urlManager->baseUrl . '/' . $menu->link;
                                        }
                                    }
                                    
                                        $menus_sub = backend\models\Menu::find()->localized()->where(['menu_id' => $menu->id])->andWhere(['status' => 1])->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->all();
                                   
                                    if (!empty($menus_sub)) {
                                        ?>
                                        <li>
                                            <a class="first" href="#"><?= $menu->name ?> <span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <?php
                                                foreach ($menus_sub as $menu_sub) {
                                                    $link = "#";
                                                    if (substr($menu_sub->link, 0, 4) == 'http') {
                                                        $link = $menu_sub->link;
                                                    } else {
                                                        if (isset($menu_sub->content_id)) {
                                                            $link = Yii::$app->urlManager->baseUrl . '/index.php?r=site/detail&id=' . $menu_sub->content_id;
                                                        } else if (isset($menu_sub->link) && !empty($menu_sub->link)) {
                                                            $link = Yii::$app->urlManager->baseUrl . '/' . $menu_sub->link;
                                                        }
                                                    }
                                                        $menus_sub_sub = backend\models\Menu::find()->localized()->where(['menu_id' => $menu_sub->id])->andWhere(['status' => 1])->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->all();
                                                    
                                                    if (!empty($menus_sub_sub)) {
                                                        ?>
                                                        <li>
                                                            <a href="#"><?= $menu_sub->name ?> <span class="caret"></span></a>
                                                            <ul class="dropdown-menu">
                                                                <?php
                                                                foreach ($menus_sub_sub as $menu_sub_sub) {
                                                                    $link = "#";
                                                                    if (substr($menu_sub_sub->link, 0, 4) == 'http') {
                                                                        $link = $menu_sub_sub->link;
                                                                    } else {
                                                                        if (isset($menu_sub_sub->content_id)) {
                                                                            $link = Yii::$app->urlManager->baseUrl . '/index.php?r=site/detail&id=' . $menu_sub_sub->content_id;
                                                                        } else if (isset($menu_sub_sub->link) && !empty($menu_sub_sub->link)) {
                                                                            $link = Yii::$app->urlManager->baseUrl . '/' . $menu_sub_sub->link;
                                                                        }
                                                                    }
                                                                        $menus_sub_sub_sub = backend\models\Menu::find()->localized()->where(['menu_id' => $menu_sub_sub->id])->andWhere(['status' => 1])->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->all();
                                                                    
                                                                    if (!empty($menus_sub_sub_sub)) {
                                                                        ?>
                                                                        <li>
                                                                            <a href="#"><?= $menu_sub_sub->name ?> <span class="caret"></span></a>
                                                                            <ul class="dropdown-menu">
                                                                                <?php
                                                                                foreach ($menus_sub_sub_sub as $menu_sub_sub_sub) {
                                                                                    $link = "#";
                                                                                    if (substr($menu_sub_sub_sub->link, 0, 4) == 'http') {
                                                                                        $link = $menu_sub_sub_sub->link;
                                                                                    } else {
                                                                                        if (isset($menu_sub_sub_sub->content_id)) {
                                                                                            $link = Yii::$app->urlManager->baseUrl . '/index.php?r=site/detail&id=' . $menu_sub_sub_sub->content_id;
                                                                                        } else if (isset($menu_sub_sub_sub->link) && !empty($menu_sub_sub_sub->link)) {
                                                                                            $link = Yii::$app->urlManager->baseUrl . '/' . $menu_sub_sub_sub->link;
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                    <li>
                                                                                        <a href="<?= $link ?>"><?= $menu_sub_sub_sub->name ?></a>
                                                                                    </li>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </ul>
                                                                        </li>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <li>
                                                                            <a href="<?= $link ?>"><?= $menu_sub_sub->name ?></a>
                                                                        </li>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </ul>
                                                        </li>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <li>
                                                            <a href="<?= $link ?>"><?= $menu_sub->name ?></a>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </li>
                                        <?php
                                    } else {
                                        ?>
                                        <li>
                                            <a class="first" href="<?= $link ?>"><?= $menu->name ?></a>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>

                                <li style="float: right;margin-right:-30px;margin-top:5px;" class="visible-lg visible-md visible-sm hidden-xs">
                                <form method="post" role="search" action="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=site/search" >
                                        <input type="text" name="search" id="" placeholder="<?php echo Yii::t("app", "Search") ?>" class="input-search" style="width:150px;padding-left:5px;">
                                        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
                                        <button type="submit" class="btn-search"><span class="fa fa-search"></span></button>
                                        <a class="link_f" style="padding-left:15px !important" href="<?= Yii::$app->urlManager->baseUrl . "/index.php?r=site/language&lang=Lao" ?>"><img src="<?= Yii::$app->urlManager->baseUrl . '/images/la.jpg' ?>" style="width:20px;  border-radius: 10%;" title="<?= Yii::t("app", "Lao") ?>"/></a>
                                        <a class="link_f" style="padding-left:0px !important" href="<?= Yii::$app->urlManager->baseUrl . "/index.php?r=site/language&lang=English" ?>"><img src="<?= Yii::$app->urlManager->baseUrl . '/images/en.jpg' ?>" style="width:20px;  border-radius: 10%;" title="<?= Yii::t("app", "English") ?>"/></a>
                                    </form> 
                                </li>

                            </ul>
                        </div><!--/.nav-collapse -->
                    </div>
                </div>
            </div>
        </section>
        <section id="aa-blog-archive">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="aa-blog-archive-area aa-blog-archive-2">
                            <div>
                            <?php
                            if(Yii::$app->controller->action->id=="index")
                            {
                                $hm="967px;";
                            }else{
                                $hm="1310px;";
                            }
                            ?>
                                <div class="col-md-9 col-lg-9 col-xs-12 col-sm-12 margdiv">
                                    <div class="aa-blog-content heightauto" style="box-shadow: 0 4px 4px rgba(0, 0, 0, 0.15); min-height:<?=$hm?>">
                                        <div style="margin-bottom:10px;min-height:40px;background-color:#5588D9 !important;">
                                            <?php
                                            $maxwidth = "100%;border-top-right-radius: 10px;";
                                            ?>
                                            <div style="text-align:center !important;float:center;font-size:18px !important;color:white;font-weight: normal;background-color:#5588D9 !important;padding:5px 5px 5px 5px; max-width:<?= $maxwidth ?>width:auto;">
                                                <span><?= $this->title; ?></span>
                                            </div>
                                            <div style="clear:both;"></div>
                                        </div>

                                        <?php
                                        if (Yii::$app->session->hasFlash('success')) {
                                            echo "<div class='divcontent'> <br/>";
                                            echo Alert::widget([
                                                'type' => Alert::TYPE_SUCCESS,
                                                'title' => '',
                                                'icon' => 'glyphicon glyphicon-ok',
                                                'body' => Yii::$app->session->getFlash('success'),
                                                'showSeparator' => false,
                                                'delay' => 20000
                                            ]);
                                            echo "<br/></div>";
                                        } else if (Yii::$app->session->hasFlash('error')) {
                                            echo "<div class='divcontent'> <br/>";
                                            echo Alert::widget([
                                                'type' => Alert::TYPE_DANGER,
                                                'title' => '',
                                                'icon' => 'glyphicon glyphicon-remove',
                                                'body' => Yii::$app->session->getFlash('error'),
                                                'showSeparator' => false,
                                                'delay' => 20000
                                            ]);
                                            echo "<br/></div>";
                                        }
                                        ?>
                                        <?php echo preg_replace("/\xEF\xBB\xBF/", "", $content); ?>
                                        <div style="clear:both;"></div>
                                        <p>&nbsp;<br/></p>
                                    </div>
                                </div>
                                
                                <?php
                                $rights=SocialMedia::find()->where(['status'=>'1'])->orderBy('sort ASC')->all();
                                $i=0;
                                foreach ($rights as $right) {
                                    $i++;
                                    if($i==1)
                                    {
                                        $h="height:330px;";
                                    }else{
                                        $h="height:260px;";
                                    }
                                    ?>
                                <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 margdiv">
                                    <div style="width: 100%;box-shadow: 0 4px 4px rgba(0, 0, 0, 0.15);">
                                        <div style=" text-align:center !important;float:left;font-size:18px !important;color:white;font-weight: normal;background-color:#5588D9 !important;padding:5px 5px 5px 5px; max-width:100%;width:100%;">
                                            <span><?php
                                            if(Yii::$app->language=="en")
                                            {
                                                echo $right->title;
                                            }else{
                                                echo $right->icon ;
                                            }
                                             
                                             ?></span>
                                        </div>
                                        <div style="clear:both;"></div>
                                        <div class="sidebar-widget-new" align="center">
                                            <a href="<?=$right->link?>">
                                                <img src="<?=Yii::$app->urlManager->baseUrl?>/images/download/<?=$right->photo?>" style="<?=$h?>" class="img-responsive"/>                                           
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>
                                <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 margdiv" >
                                    <div style="width: 100%;box-shadow: 0 4px 4px rgba(0, 0, 0, 0.15);">
                                        <div style="text-align:center !important; float:left;font-size:18px !important;color:white;font-weight: normal;background-color:#5588D9 !important;padding:5px 5px 5px 5px; max-width:100%;width:100%;">
                                            <span><?= Yii::t("app", "Meeting Registration"); ?></span>
                                        </div>
                                        <div style="clear:both;"></div>
                                        <div class="sidebar-widget-new " style="padding:5px;" >
                                        <?php
                                            $model = new LoginForm();
                                            if(Yii::$app->session['username'])
                                            {
                                                $autofocus=true;
                                            }else{
                                                $autofocus=false;
                                            }
                                        ?>
                                        <?php $form = ActiveForm::begin(['id' => 'login-form','action'=>['site/login','log'=>true]]); ?>
                                        <?= $form->field($model, 'username')->textInput(['value'=>Yii::$app->session['username'],'autofocus' =>  $autofocus])->label(Yii::t('app','Username')) ?>
                                        <?= $form->field($model, 'password')->passwordInput(['value'=>Yii::$app->session['password'],])->label(Yii::t('app','Password'))  ?>
                                        <?php
                                        echo \yii\captcha\Captcha::widget([
                                            'name' => 'captcha',
                                            'captchaAction' => 'site/captcha',
                                            'options' => [
                                                'placeholder' => 'Enter Captcha'
                                                   , 'Class' => ' col-md-6 col-xs-12 col-sm-12'
                                                   , 'style' => 'margin-top: 10px;    margin-bottom: 15px;    display: block;
                                                   height: 34px;
                                                   padding: 6px 12px;
                                                   font-size: 14px;
                                                   line-height: 1.42857143;
                                                   color: #555;
                                                   background-color: #fff;
                                                   background-image: none;
                                                   border: 1px solid #ccc;
                                                   border-radius: 4px;
                                                   -webkit-box-shadow: '
                                           ]
                                        ]);
                                        unset(Yii::$app->session['username']);
                                        unset(Yii::$app->session['password']);
                                        ?>
                                        <div class="col-md-12" style="color:red">
                                        <?php
                                            if(\Yii::$app->session->hasFlash('errorcaptcha'))
                                            {
                                                echo \Yii::$app->session->getFlash('errorcaptcha');
                                            }
                                        ?>
                                        </div>
                                        <div class="form-group">
                                        
                                        <div align="right">
                                        <?= Html::submitButton('<span class="glyphicon glyphicon-log-in"></span> ' . Yii::t('app', "Login"), ['class' => 'btn btn-primary btn-sm', 'name' => 'login-button']) ?></div>
                                        </div>
                                        <?php ActiveForm::end(); ?>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <!-- footer -->
        <footer id="aa-footer">
            <!-- footer-bottom -->
            <div class="aa-footer-bottom" style="background-color: #062A5A !important;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <p style="color:white !important;text-align:center !important;font-size:11pt;margin:10px;"><?php echo Yii::t('app', "Copyright") ?> &copy; 2017<?php if (date('Y') != 2017) echo "-" . date('Y'); ?>
                                    <?php echo Yii::t('app', 'MPT. All Rights Reserved.') ?><span ><?php echo Yii::t("app", "Designed and Developed by"); ?> <a href="http://cyberia.la/" target="_blank" class="footer-a" style="text-decoration: none;color:#5588D9;"><?php echo Yii::t("app", "CYBERIA") ?>.</a></span> <?php echo Yii::t("app", "Vientiane Lao P.D.R") ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- / footer -->

        <?php $this->endBody() ?>

        <script type="text/javascript">
            jQuery(function () {
                jQuery('#camera_wrap_1').camera({
                    //height: '350px',
                    loader: 'bar',
                    thumbnails: false,
                    pagination: false,
                });
            });

            $(document).ready(function () {
                $('.dropdown').hover(function () {
                    $(this).find('.dropdown-menu').first().stop(true, true).slideDown(150);
                }, function () {
                    $(this).find('.dropdown-menu').first().stop(true, true).slideUp(105)
                });

                $("#aa-blog-archive").on("mouseover", function () {
                    $("#contentmenu").removeClass("show");
                    $("#contentmenu").addClass("hide");
                    $("#contentmenu").html('&nbsp;<br/><br/>');
                });

                $("#headertop").on("mouseover", function () {
                    $("#contentmenu").removeClass("show");
                    $("#contentmenu").addClass("hide");
                    $("#contentmenu").html('&nbsp;<br/><br/>');
                });

                $("#aa-footer").on("mouseover", function () {
                    $("#contentmenu").removeClass("show");
                    $("#contentmenu").addClass("hide");
                    $("#contentmenu").html('&nbsp;<br/><br/>');
                });

                $('.slider').slide();
                // Disable the slide links in the example...
                $('.slider').on('click', 'a', function (e) {
                    e.preventDefault();
                });

            });
            /*For second carousel (Services)*/
            $(document).ready(function () {
                $('#carousel1').carousel({
                    interval: 2000
                });
                $('#carousel2').carousel({
                    interval: 2000
                });
            });

            $(document).ready(function () {
                var x = document.getElementsByClassName("divcontent");
                if (x.length > 0) {
                    for (j = 0; j < x.length; j++) {
                        var imgs = x[j].getElementsByTagName("img");
                        var count = imgs.length;
                        for (i = 0; i < count; i++) {
                            imgs[i].classList.add("img-responsive");
                        }
                        var tables = x[0].getElementsByTagName("table");
                        var counttab = tables.length;
                        /* for (i = 0; i < counttab; i++) {
                         tables[i].classList.add("table");
                         tables[i].classList.add("table-striped");
                         tables[i].classList.add("table-inverse");
                         tables[i].classList.add("table-bordered");
                         }*/
                    }
                }

                var x = document.getElementsByClassName("summarycontent");
                if (x.length > 0) {
                    for (j = 0; j < x.length; j++) {
                        var imgs = x[j].getElementsByTagName("img");
                        var count = imgs.length;
                        for (i = 0; i < count; i++) {
                            imgs[i].classList.add("img-responsive");
                            imgs[i].classList.add("imgresp");
                        }
                    }
                }
                var url = window.location.href;
                $('#topmenu a').each(function () {
                    if (url == this.href) {
                        $(this).addClass('active');
                        $(this).removeClass('first');

                        if ($(this).parent("li")) {
                            $(this).parent("li").addClass('activemenu');
                        }
                        if ($(this).parent().parent("li")) {
                            $(this).parent().parent("li").addClass('activemenu');
                        }

                        if ($(this).parent().parent().parent("li")) {
                            $(this).parent().parent().parent("li").children("a").removeClass("first");
                            $(this).parent().parent().parent("li").addClass('activemenu');
                        }

                    }
                });

                $('#topmenu1 a').each(function () {
                    if (url == this.href) {
                        $(this).addClass('active');
                        $(this).removeClass('first');

                        if ($(this).parent("li")) {
                            $(this).parent("li").addClass('activemenu');
                        }
                        if ($(this).parent().parent("li")) {
                            $(this).parent().parent("li").addClass('activemenu');
                        }

                        if ($(this).parent().parent().parent("li")) {
                            $(this).parent().parent().parent("li").addClass('activemenu');
                        }

                    }
                });
            });

        </script>

    </body>
</html>
<?php $this->endPage() ?>
