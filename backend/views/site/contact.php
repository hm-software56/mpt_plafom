<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use kartik\alert\Alert;

/* @var $this yii\web\View */
/* @var $model backend\models\Issue */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Contact');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (!empty(Yii::$app->params["contactContentId"])) { ?>
    <?php
    if (!empty(Yii::$app->params["contactContentId"])) {
        $id = (int) Yii::$app->params["contactContentId"];
        $cont = null;
        if (Yii::$app->language == Yii::$app->params["multiSecondLang"]) {
            $subQuery = \backend\models\ContentTranslate::find()->where(['is not', 'title', NULL])->andWhere(['!=', 'title', ""])->andWhere(['=', 'language', Yii::$app->params["codeSecondLang"]])->select('content_id');
            $cont = \backend\models\Content::find()->localized(Yii::$app->language)->where(['in', 'id', $subQuery])->andWhere(['status' => 1])->andWhere(['id' => $id])->one();
        } else {
            $cont = \backend\models\Content::find()->localized(Yii::$app->language)->where(['status' => 1])->andWhere(['id' => $id])->one();
        }

        if (isset($cont)) {
            $verif = 1;
            $pdfs = \backend\models\GallaryUploads::find()->where(['ref' => $cont->ref])->andWhere(['or', ['like', 'real_filename', ".pdf"], [ 'like', 'real_filename', ".doc"]])->orderBy(['upload_id' => SORT_ASC])->all();
            $slides = \backend\models\GallaryUploads::find()->where(['ref' => $cont->ref])->andWhere(['not like', 'real_filename', ".pdf"])->andWhere(['not like', 'real_filename', ".pdf"])->orderBy(['upload_id' => SORT_ASC])->all();
            echo $this->render('detail', [
                'model' => $cont,
                'contentCategory' => $cont->contentCategory,
                'slides' => $slides,
                'pdfs' => $pdfs,
            ]);
            echo "<p>&nbsp;<br/></p>";
        }
    }
    ?>
    <?php
}
?>
<div class="divcontent">
    <fieldset class="scheduler-border">
        <legend class="scheduler-border"><?= Yii::t("app", "Contact Form") ?></legend>
        <div class="control-group">
            <div class="divcontent">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

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
                        'delay' => 10000
                    ]);
                }
                ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Send Request'), ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </fieldset>
</div>


