<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\widgets\FileInput;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Gallery */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gallery-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'remove_photo')->hiddenInput(['value' => 0])->label(FALSE) ?>
    <?php if (!$model->isNewRecord && isset($model->photo) && !empty($model->photo)) { ?>
        <div id="rm_df" style="width:100%;float:left;"><button title="<?= Yii::t('app', "Remove old photo"); ?>" class="btn btn-sm btn-danger" onclick="$('#gallery-remove_photo').val('1');
                    $('#rm_df').css({'display': 'none'});
                    return false;"><span class="glyphicon glyphicon-remove"></span> <?php echo Yii::t('app', "Remove old photo"); ?></button></div>
                                                           <?php } ?>
    <div style="float:left;"><?= $form->field($model, 'photo')->fileInput(['maxlength' => true]) ?> </div>
    <div style="float:left;"><br/><button title="<?= Yii::t('app', "Remove photo"); ?>" class="btn btn-sm btn-danger" onclick="$('#gallery-photo').val('');
            return false;"><span class="glyphicon glyphicon-remove"></span> <?php echo Yii::t('app', "Remove photo"); ?></button>
    </div>
    <div style="clear:both;"></div>

    <?php
    foreach (Yii::$app->params['languages'] as $language => $value) {
        if ($language != Yii::$app->params['defaultLang']) {
            ?>
            <fieldset class="scheduler-border">
                <legend class="scheduler-border"><?= $value ?></legend>
                <div class="control-group">
                    <?= $form->field($model, 'title_' . $language)->textInput(['maxlength' => true])->label(Yii::t("app", 'Title')) ?>

                    <?php
                    echo $form->field($model, 'detail_' . $language)->widget(CKEditor::className(), [
                        'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                            'preset' => 'full',
                            'inline' => false,
                        ]),
                    ])->label(Yii::t("app", 'Details'));
                    ?>
                </div>
            </fieldset>
            <?php
        } else {
            ?>
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?php
            echo $form->field($model, 'detail')->widget(CKEditor::className(), [
                'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                    'preset' => 'full',
                    'inline' => false,
                ]),
            ]);
        }
    }
    ?>

    <?= $form->field($model, 'date')->textInput()->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control']]) ?>
    <?= $form->field($model, 'sort')->textInput(); ?>

    <?= $form->field($model, 'status')->checkbox() ?>
    <?= $form->field($model, 'ref')->hiddenInput(['maxlength' => 100])->label(false); ?>

    <div class="form-group field-upload_files">
        <label class="control-label" for="upload_files[]"> <?php echo Yii::t("app", 'Upload Images'); ?> </label>
        <div>
            <?=
            FileInput::widget([
                'name' => 'upload_ajax[]',
                'options' => ['multiple' => true, 'accept' => 'image/*'],
                'pluginOptions' => [
                    'overwriteInitial' => false,
                    'initialPreviewShowDelete' => true,
                    'initialPreview' => $initialPreview,
                    'initialPreviewConfig' => $initialPreviewConfig,
                    'uploadUrl' => Url::to(['/gallery/upload-ajax']),
                    'uploadExtraData' => [
                        'ref' => $model->ref,
                    ],
                    'maxFileCount' => 100,
                    'previewFileType' => 'any'
                ]
            ]);
            ?>
            <span style="color:red"><?= Yii::t('app', 'Please click the button upload above') ?></span>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
