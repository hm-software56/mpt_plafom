<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\IssueSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="issue-search">
    <?php
    $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
    ]);
    ?>
    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
        <?= $form->field($model, 'subject') ?>
        <?= $form->field($model, 'date_from')->textInput()->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control']]) ?>
    </div>
    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
        <?= $form->field($model, 'issue_category_id')->dropDownList(\yii\helpers\ArrayHelper::map(backend\models\IssueCategory::getList(), 'id', 'title'), ['prompt' => '']) ?>
        <?= $form->field($model, 'date_to')->textInput()->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control']]) ?>
    </div>

    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 nopaddding">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
