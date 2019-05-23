<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SocialMedia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="social-media-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'remove_photo')->hiddenInput(['value' => 0])->label(FALSE) ?>
    <div style="float:left;"><?= $form->field($model, 'photo')->fileInput(['maxlength' => true]) ?> </div>
    <div style="float:left;"><br/><button title="<?= Yii::t('app', "Cancel photo"); ?>" class="btn btn-sm btn-danger" onclick="$('#socialmedia-photo').val('');
            return false;"><span class="glyphicon glyphicon-remove"></span> <?php echo Yii::t('app', "Cancel photo"); ?></button>
                                          <?php if (!$model->isNewRecord && isset($model->photo) && !empty($model->photo)) { ?>
            <button id="rm_sp" title="<?= Yii::t('app', "Remove old photo"); ?>" class="btn btn-sm btn-danger" onclick="$('#socialmedia-remove_photo').val('1');
                    $('#rm_sp').css({'display': 'none'});
                    return false;"><span class="glyphicon glyphicon-remove"></span> <?php echo Yii::t('app', "Remove old photo"); ?></button>
                <?php } ?>
    </div>
    <div style="clear:both;"></div>
    <?= $form->field($model, 'icon')->textInput(['maxlength' => true])->label(Yii::t('app','Title')) ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label(Yii::t('app','Title English')) ?>
    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->checkbox() ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
