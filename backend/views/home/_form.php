<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\TypeHome;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Home */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="home-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php
    foreach (Yii::$app->params['languages'] as $language => $value) {
        if ($language != Yii::$app->params['defaultLang']) {
            ?>
            <?= $form->field($model, 'name_'.$language)->textInput(['maxlength' => true]) ?>
            
            <?php
        } else {
            ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?php
        }}?>
    <?= $form->field($model, 'like')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type_home_id')->dropDownList(ArrayHelper::map(TypeHome::find()->localized()->all(),'id','name')) ?>
    
    <?= $form->field($model, 'photo')->fileInput() ?>
    
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
