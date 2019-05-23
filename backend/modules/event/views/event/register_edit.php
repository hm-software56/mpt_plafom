<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\event\models\Event;
$this->title=Yii::t('app','Edit');
?>
<?php $form = ActiveForm::begin(['options'=>['autocomplete'=>'off']]);?>
<?=$form->field($model, 'title')->textInput(['maxlength' => true])?>
<?=$form->field($model, 'first_name')->textInput(['maxlength' => true])?>
<?=$form->field($model, 'last_name')->textInput(['maxlength' => true])?>
<?= $form->field($model, 'gender')->radioList(['Male' => Yii::t('app','Male'), 'Female'=>Yii::t('app','Female')])?>
<?=$form->field($model, 'position')->textInput(['maxlength' => true])?>
<?=$form->field($model, 'telephone')->textInput(['maxlength' => true])?>
<?=$form->field($model, 'email')->textInput(['maxlength' => true])?>
<div class="form-group" align="right">
    <?=Html::submitButton('<span class="fa fa-save"></span> '.Yii::t('app', 'Edit'), ['class' =>'btn btn-success'])?>
</div>
<?php ActiveForm::end();?>