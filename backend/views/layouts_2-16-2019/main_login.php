<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAssetLogin;
use yii\helpers\Html;
use yii\widgets\Pjax;

AppAssetLogin::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" id="inner">
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
    <body style="margin:0 auto; width:90%;max-width:500px;background-color:transparent;margin-top:50px;">
        <?php $this->beginBody() ?>
        <?php
        Pjax::begin();
        ?>

        <div style="margin:0 auto;background-color: white !important;box-shadow: 0 4px 4px rgba(0, 0, 0, 0.15);padding: 10px;">
            <div class="login-logo" style="font-size: 30px !important;">
                <div class="image" style="text-align: center !important;margin: 0 auto;">
                    <p style="text-align: center !important;margin: 0 auto;font-weight: bold;text-transform: uppercase;"><?= Yii::$app->params["nameProject"] . " " . Yii::t('app', "ADMIN PANEL") ?></p>
                </div>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body" >
                <br/>
                <?php echo preg_replace("/\xEF\xBB\xBF/", "", $content); ?>
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
        <?php
        Pjax::end();
        ?>
        <?php $this->endBody() ?>

    </body>
</html>
<?php $this->endPage() ?>
