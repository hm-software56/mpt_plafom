<?php
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
?>

<?php
$this->title = Yii::t('app', '404 Error - Not Found');
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="error">
    <div class="errror-page-area" style="text-align: center;">
        <h1 class="error-title"><span class="fa fa-bug" style="font-size: 40px !important;"></span></h1>
        <div class="error-content">
            <span style="font-size: 20px !important;"><?php echo Yii::t('app', "Opps!"); ?></span>
            <p style="font-size: 20px !important;"><?php echo Yii::t('app', "We're sorry, but the page you were looking for doesn't exist."); ?></p><br/><br/>
            <a class="btn btn-primary btn-color" href ="index.php?r=site/index"><?php echo Yii::t('app', "Home Page"); ?></a><?php if (!empty(\Yii::$app->user->id)) { ?><span style="padding-left:20px;">&nbsp;</span><a class="btn btn-primary btn-color" href ="index.php?r=site/indexadmin"><?php echo Yii::t('app', "Admin Page"); ?><?php } ?></a>
        </div>
    </div>
</section>
