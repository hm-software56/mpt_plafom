<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Video */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="video-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, "link")->textInput(['maxlength' => true]) ?>
    <?php
    foreach (Yii::$app->params['languages'] as $language => $value) {
        if ($language != Yii::$app->params['defaultLang']) {
            ?>
            <?= $form->field($model, 'title_' . $language)->textInput(['maxlength' => true])->label(Yii::t("app", 'Title in ') . $value) ?>
            <?php
        } else {
            ?>
            <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label(Yii::t("app", 'Title in ') . $value) ?>
            <?php
        }
    }
    ?>
    <?= $form->field($model, "sort")->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date')->textInput()->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control']]) ?>
    <?= $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
