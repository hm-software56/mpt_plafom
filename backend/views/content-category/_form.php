<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model backend\models\ContentCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    foreach (Yii::$app->params['languages'] as $language => $value) {
        if ($language != Yii::$app->params['defaultLang']) {
            ?>
            <fieldset class="scheduler-border">
                <legend class="scheduler-border"><?= $value ?></legend>
                <div class="control-group">
                    <?= $form->field($model, 'title_' . $language)->textInput(['maxlength' => true])->label('Title in ' . $value) ?>
                    <?php
                    if (Yii::$app->params['nbAdditionalCategory'] > 0) {
                        $form->field($model, 'add_1_' . $language)->widget(CKEditor::className(), [
                            'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                                'preset' => 'full',
                                'inline' => false,
                            ]),
                        ])->label(Yii::$app->params['labelContentCategoryHasAdd1']);
                    }
                    ?>
                    <?php
                    if (Yii::$app->params['nbAdditionalCategory'] > 1) {
                        echo $form->field($model, 'add_2_' . $language)->widget(CKEditor::className(), [
                            'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                                'preset' => 'full',
                                'inline' => false,
                            ]),
                        ])->label(Yii::$app->params['labelContentCategoryHasAdd2']);
                    }
                    ?>
                </div>
            </fieldset>
            <?php
        } else {
            ?>
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?php
            if (Yii::$app->params['nbAdditionalCategory'] > 0) {
                echo $form->field($model, 'add_1')->widget(CKEditor::className(), [
                    'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                        'preset' => 'full',
                        'inline' => false,
                    ]),
                ])->label(Yii::$app->params['labelContentCategoryHasAdd1']);
            }
            ?>
            <?php
            if (Yii::$app->params['nbAdditionalCategory'] > 1) {
                echo $form->field($model, 'add_2')->widget(CKEditor::className(), [
                    'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                        'preset' => 'full',
                        'inline' => false,
                    ]),
                ])->label(Yii::$app->params['labelContentCategoryHasAdd2']);
            }
            ?>
            <?php
        }
    }
    ?>

    <?= $form->field($model, 'has_summary')->checkbox() ?>

    <?= $form->field($model, 'has_details')->checkbox() ?>

    <?= $form->field($model, 'has_photo')->checkbox() ?>

    <?= $form->field($model, 'has_keywords')->checkbox() ?>

    <?= $form->field($model, 'has_meta_keywords')->checkbox() ?>

    <?= $form->field($model, 'has_start_date')->checkbox() ?>

    <?= $form->field($model, 'has_end_date')->checkbox() ?>

    <?= $form->field($model, 'has_multi_attachment')->checkbox() ?>

    <?= $form->field($model, 'is_legal_type')->checkbox() ?>

    <?php //echo $form->field($model, 'has_add1')->checkbox(); ?>
    <?php //echo $form->field($model, 'has_add2')->checkbox(); ?>
    <?php //echo $form->field($model, 'has_add3')->checkbox(); ?>
    <?php //echo $form->field($model, 'has_add4')->checkbox(); ?>
    <?php //echo $form->field($model, 'has_add5')->checkbox(); ?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
