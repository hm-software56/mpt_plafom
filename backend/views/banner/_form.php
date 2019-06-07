<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\color\ColorInput;
/* @var $this yii\web\View */
/* @var $model backend\models\Banner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'photo_banner')->fileInput(['maxlength' => true]) ?>
    <?php
         $url = \Yii::$app->request->BaseUrl . '/images/' . Yii::$app->params['downloadFilePath'] . '/' . $model->photo_banner;
         echo  Html::img($url, [ 'class' => 'img-responsive']);
    ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'bg_menu')->widget(ColorInput::classname(), ['options' => ['placeholder' => ''],]); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'bg_menu_focus')->widget(ColorInput::classname(), ['options' => ['placeholder' => ''],]); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'bg_menu_active')->widget(ColorInput::classname(), ['options' => ['placeholder' => ''],]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'bg_title')->widget(ColorInput::classname(), [
            'options' => ['placeholder' => ''],
            ]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'bg_footer')->widget(ColorInput::classname(), [
        'options' => ['placeholder' => ''],
        ]); ?>
        </div>
    </div>

    <?= $form->field($model, 'footer_text')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
