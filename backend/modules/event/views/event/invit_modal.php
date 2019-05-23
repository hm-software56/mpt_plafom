<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\event\models\Event;
?>

<div class="modal fade in show" id="myModal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <?php
        if (isset($rg_id)) {
       echo  Yii::t('app','Add invitation');
        }else{
          echo  Yii::t('app','Edit invitation');
        }
        ?>
          <a href="<?=Yii::$app->request->referrer?>" ><span class="close" aria-hidden="true">&times;</span></a>
      </div>
      <div class="modal-body">
        <?php 
        if (isset($rg_id)) {
            $form = ActiveForm::begin(['action' => ['event/invitcreate','rg_id'=>$rg_id]]);
        }else{
            $form = ActiveForm::begin(['action' => ['event/invitedit','id'=>$invitation->id]]);
        }
        ?>
            <?=$form->field($invitation, 'org_name1')->textInput(['maxlength' => true])?>
            <?=$form->field($invitation, 'org_name2')->textInput(['maxlength' => true])?>
            <?=$form->field($invitation, 'pax')->textInput(['maxlength' => true])?>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><?=Yii::t('app','Save')?></button>
            </div>
        <?php ActiveForm::end();?>
      </div>
      
    </div>
  </div>
</div>