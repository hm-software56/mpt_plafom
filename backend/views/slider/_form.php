<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model backend\models\Slider */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slider-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'remove_photo')->hiddenInput(['value' => 0])->label(FALSE) ?>
    <div style="float:left;"><?= $form->field($model, 'photo')->fileInput(['maxlength' => true]) ?> </div>
    <div style="float:left;"><br/><button title="<?= Yii::t('app', "Cancel photo"); ?>" class="btn btn-sm btn-danger" onclick="$('#slider-photo').val('');
            return false;"><span class="glyphicon glyphicon-remove"></span> <?php echo Yii::t('app', "Cancel photo"); ?></button>
                                          <?php if (!$model->isNewRecord && isset($model->photo) && !empty($model->photo)) { ?>
            <button id="rm_sp" title="<?= Yii::t('app', "Remove old photo"); ?>" class="btn btn-sm btn-danger" onclick="$('#slider-remove_photo').val('1');
                    $('#rm_sp').css({'display': 'none'});
                    return false;"><span class="glyphicon glyphicon-remove"></span> <?php echo Yii::t('app', "Remove old photo"); ?></button>
                <?php } ?>
    </div>
    <div style="clear:both;"></div>
    <span style="color:red"><?= Yii::t('app', 'Size of the picture: Width:1107px - Height:340px') ?></span>
    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
    <?php
    foreach (Yii::$app->params['languages'] as $language => $value) {
        if ($language != Yii::$app->params['defaultLang']) {
            ?>
            <?= $form->field($model, 'title_' . $language)->textInput(['maxlength' => true])->label('Name in ' . $value) ?>
            <?=
            $form->field($model, 'details_' . $language)->widget(CKEditor::className(), [
                'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                    'preset' => 'full',
                    'inline' => false,
                ]),
            ])->label('Details in ' . $value)
            ?>
            <?php
        } else {
            ?>
            <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Name in ' . $value) ?>
            <?=
            $form->field($model, 'details')->widget(CKEditor::className(), [
                'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                    'preset' => 'full',
                    'inline' => false,
                ]),
            ])->label('Details in ' . $value)
            ?>
            <?php
        }
        ?>
    <?php }
    ?>
    <?= $form->field($model, 'status')->checkbox() ?>
    <?= $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
