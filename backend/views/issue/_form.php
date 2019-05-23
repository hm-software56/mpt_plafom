<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Issue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="issue-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'remove_file')->hiddenInput(['value' => 0])->label(FALSE) ?>
    <div style="float:left;"><?= $form->field($model, 'file')->fileInput(['maxlength' => true]) ?> </div>
    <div style="float:left;"><br/><button title="<?= Yii::t('app', "Cancel file"); ?>" class="btn btn-sm btn-danger" onclick="$('#issue-file').val('');
            return false;"><span class="glyphicon glyphicon-remove"></span> <?php echo Yii::t('app', "Cancel file"); ?></button>
                                          <?php if (!$model->isNewRecord && isset($model->file) && !empty($model->file)) { ?>
            <button id="rm_sp" title="<?= Yii::t('app', "Remove old file"); ?>" class="btn btn-sm btn-danger" onclick="$('#issue-remove_file').val('1');
                        $('#rm_sp').css({'display': 'none'});
                        return false;"><span class="glyphicon glyphicon-remove"></span> <?php echo Yii::t('app', "Remove old file"); ?></button>
                <?php } ?>
    </div>
    <div style="clear:both;"></div>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'issue_category_id')->dropDownList(\yii\helpers\ArrayHelper::map(backend\models\IssueCategory::getList(), 'id', 'title'), ['prompt' => '']) ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
