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
        
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header" style="background-color:#062A5A !important;">
                                        <h4 class="title"><?= $this->title; ?></h4>
                                    </div>
                                    <div class="card-content table-responsive">
                                        <?php echo preg_replace("/\xEF\xBB\xBF/", "", $content); ?>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>