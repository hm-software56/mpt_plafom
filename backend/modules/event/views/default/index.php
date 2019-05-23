<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
use kartik\time\TimePicker;
use kartik\datetime\DateTimePicker;
/* @var $this yii\web\View */
/* @var $model backend\modules\event\models\Event */
/* @var $form yii\widgets\ActiveForm */
$this->title=Yii::t('app','Registration Form');
if($count_rg >= $invitation->pax)
{
    $desable=true;
}else{
    $desable=false;
}
?>
<div class="col-md-12">
    <div class="row">
        <div style="font-size:16px;" class="col-md-6 col-sm-6 col-xs-6">
                <?=Yii::t('app','Please fill personal information in form registration')?>
        </div>
        <div style="font-size:16px; color:red" class="col-md-6 col-sm-6 col-xs-6" align="right">
            <?=Yii::t('app','maximum registration')." ".$invitation->pax." ".Yii::t('app','person')?><br/>
            <a href="#" data-toggle="modal" data-target="#rg"><span style="font-size:12px; color:green"><?=Yii::t('app','Already registered')." ".$count_rg." ".Yii::t('app','person')?></span></a>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin(['options'=>['autocomplete'=>'off']]);?>
            <?=$form->field($model, 'title')->textInput(['maxlength' => true,'disabled' => $desable])?>
            <?=$form->field($model, 'first_name')->textInput(['maxlength' => true,'disabled' => $desable])?>
            <?=$form->field($model, 'last_name')->textInput(['maxlength' => true,'disabled' => $desable])?>
            <?= $form->field($model, 'gender')->radioList(['Male' => Yii::t('app','Male'), 'Female'=>Yii::t('app','Female')],['itemOptions' => ['disabled' =>$desable]])?>
            <?=$form->field($model, 'position')->textInput(['maxlength' => true,'disabled' => $desable])?>
            <?=$form->field($model, 'telephone')->textInput(['maxlength' => true,'disabled' => $desable])?>
            <?=$form->field($model, 'email')->textInput(['maxlength' => true,'disabled' => $desable])?>
            <div class="form-group" align="right">
                <?=Html::submitButton('<span class="fa fa-send"></span> '.Yii::t('app', 'Submit'), ['class' =>'btn btn-success','disabled' =>$desable])?>
            </div>
            <?php ActiveForm::end();?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="rg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?=Yii::t('app','List person already registered')?></h4>
      </div>
      <div class="modal-body">
      <table class="table table-bordered" id="tbscroll">
        <tr style="background-color:#5588D9;color:#ffffff;">
            <th style="white-space: nowrap;"><?=Yii::t('app','No.')?></th>
            <th style="white-space: nowrap;"><?=Yii::t('app','Title Persion')?></th>
            <th style="white-space: nowrap;"><?=Yii::t('app','First name and last name')?></th>
            <th style="white-space: nowrap;"><?=Yii::t('app','Gender')?></th>
            <th style="white-space: nowrap;"><?=Yii::t('app','Position')?></th>
            <th style="white-space: nowrap;"><?=Yii::t('app','Organization')?></th>
            <th style="white-space: nowrap;"><?=Yii::t('app','Telephone')?></th>
            <th style="white-space: nowrap;"><?=Yii::t('app','Email')?></th>
        </tr>
        <?php
        $i=0;
        foreach ($registered as $registered) {
            $i++;
            ?>
        <tr>
        </tr>
            <td><?=$i?></td>
            <td style="white-space: nowrap;"><?=$registered->title?></td>
            <td style="white-space: nowrap;"><?=$registered->first_name." ".$registered->last_name?></td>
            <td style="white-space: nowrap;"><?=($registered->gender=="Male")?Yii::t('app','Male'):Yii::t('app','Female')?></td>
            <td style="white-space: nowrap;"><?=$registered->position?></td>
            <td style="white-space: nowrap;"><?=$registered->org_name?></td>
            <td style="white-space: nowrap;"><?=$registered->telephone?></td>
            <td style="white-space: nowrap;"><?=$registered->email?></td>
            
        <?php
        }
        ?>
      </table>
      </div>
    </div>
  </div>
</div>