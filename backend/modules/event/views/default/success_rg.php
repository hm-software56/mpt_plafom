<?php
use yii\helpers\Url;
$this->title=Yii::t('app','Registration Form')
?>
<div class="col-md-12">
    <div align="center" style="min-height:200px; padding-top:100px;">
        <h4 style="color:green"><?=Yii::t('app','Your submit registered successfully <br/><br/> Thank you!')?></h4>
        <h4 ><a style="color:red" href="<?=Url::to(['default/index', 'rg' =>$invitation->registration_code])?>"><?=Yii::t('app','Please click here register next person >>')?></a></h4>
    </div>
</div>