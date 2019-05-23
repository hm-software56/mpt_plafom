<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\IssueCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="issue-category-form">
    <?php $form = ActiveForm::begin(); ?>

    <?php
    foreach (Yii::$app->params['languages'] as $language => $value) {
        if ($language != Yii::$app->params['defaultLang']) {
            ?>
            <?= $form->field($model, 'title_' . $language)->textInput(['maxlength' => true])->label('Title in ' . $value) ?>
            <?php
        } else {
            ?>
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?php
        }
    }
    ?>
    <?= $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
