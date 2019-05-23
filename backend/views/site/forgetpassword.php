<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use kartik\alert\Alert;
?>
<div class="site-login">
    <p style="text-align: center !important;margin: 0 auto;font-weight: bold;color:blue;font-size: 16px;"><b><?= Yii::t('app', "Forget password"); ?></b></p>
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
    <div class="form-group <?php
    if (Yii::$app->session->hasFlash('su')) {
        echo "required has-error";
    }
    ?>">

        <label class="control-label"><?= Yii::t('app', 'Code') ?></label>
        <?php
        echo \yii\captcha\Captcha::widget([
            'name' => 'captcha',
            'captchaAction' => 'site/captcha',
        ]);
        ?>
        <p align="right" style="font-size:9pt;font-weight:bold;font-style: italic;"><span class="fa fa-warning"></span> <?php echo Yii::t("app", "Click on the captcha image to refresh"); ?></p>
        <?php
        if (Yii::$app->session->hasFlash('errorcaptcha')) {
            echo Alert::widget([
                'type' => Alert::TYPE_DANGER,
                'title' => '',
                'icon' => 'glyphicon glyphicon-remove',
                'body' => Yii::$app->session->getFlash('errorcaptcha'),
                'showSeparator' => false,
                'delay' => 3000
            ]);
        }
        ?>
    </div>
    <div class="form-group">
        <div align="left" style="float:left;width:50%">
            <a class="btn btn-warning" href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=site/index"><span class="glyphicon glyphicon-backward"></span> <?= Yii::t('app', "Back"); ?></a></div>
        <div align="right" style="float:right;width:50%"><?= Html::submitButton('<span class="glyphicon glyphicon-send"></span> ' . Yii::t('app', "Send request"), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?></div>
    </div>
    <?php ActiveForm::end(); ?>
    <div align="right" style="font-weight: bold;"><a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=site/login"><?= Yii::t('app', "Go to Login Page"); ?></a><br/></div>
</div>
