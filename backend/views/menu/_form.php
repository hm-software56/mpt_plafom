<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $setting = null;
    if (isset(Yii::$app->session["setting"])) {
        $setting = Yii::$app->session["setting"];
    }
    foreach (Yii::$app->params['languages'] as $language => $value) {
        if ($language != Yii::$app->params['defaultLang']) {
            ?>
            <?= $form->field($model, 'name_' . $language)->textInput(['maxlength' => true])->label(Yii::t("app", 'Name in ') . $value) ?>
            <?php
        } else {
            ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?php
        }
    }
    ?>
    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'content_id')->dropDownList(\yii\helpers\ArrayHelper::map(backend\models\Content::getListstatic(), 'id', 'title'), ['prompt' => '']) ?>
    <?= $form->field($model, 'status')->checkbox() ?>
    <?php if (isset($setting) && $setting->has_menu_top) { ?>
        <?= $form->field($model, 'top')->checkbox() ?>
    <?php } ?>
    <?php if (isset($setting) && $setting->has_menu_left) { ?>
        <?= $form->field($model, 'left')->checkbox() ?>
    <?php } ?>
    <?php if (isset($setting) && $setting->has_menu_right) { ?>
        <?= $form->field($model, 'right')->checkbox() ?>
    <?php } ?>

    <?php if (isset($setting) && $setting->has_menu_bottom) { ?>
        <?= $form->field($model, 'bottom')->checkbox() ?>
    <?php } ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?php
    if ($model->isNewRecord) {
        ?>
        <?= $form->field($model, 'menu_id')->hiddenInput(['value' => isset($_GET['parent']) ? $_GET['parent'] : NULL])->label(FALSE) ?>
        <?php
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
