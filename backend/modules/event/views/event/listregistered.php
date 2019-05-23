<?php

use yii\helpers\Html;
$this->title=$event->event_title;
?>
<script>
function printContent(el) {
    var restorepage = document.body.innerHTML;
    var printcontent = document.getElementById(el).innerHTML;
    document.body.innerHTML = printcontent;
    window.print();
    document.body.innerHTML = restorepage;
}
</script>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">

    <?php
     echo Html::a('<span class="glyphicon glyphicon-backward" style="color: white;"></span> '.Yii::t('app','Back').'', ['index'], ['class' => 'btn btn-primary']);
?>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" align="right">
    <button class="btn btn-success" onclick="printContent('print')"><span class="glyphicon glyphicon-print"
            style="color: white;"></span> <?=Yii::t('app','Print')?></button>
    <?php
     echo Html::a('<i class="fa fa-file-excel-o" aria-hidden="true"></i> '.Yii::t('app','EXCEL').'', ['exportlistregistered','id'=>$event->id], ['class' => 'btn btn-danger']);
?>
</div>
<div id="print" style="display: none;">
<table class="table table-bordered">
    <tr style="background-color:#5588D9;color:#ffffff;">
        <th><?=Yii::t('app','No.')?></th>
        <th><?=Yii::t('app','Title Persion')?></th>
        <th><?=Yii::t('app','Name')?></th>
        <th><?=Yii::t('app','Position')?></th>
        <th><?=Yii::t('app','Organization')?></th>
        <th><?=Yii::t('app','Telephone')?></th>
        <th><?=Yii::t('app','Email')?></th>
    </tr>
    <?php
        $i=0;
        foreach ($model as $registered) {
            $i++;
        ?>
    <tr>
        <td><?=$i?></td>
        <td><?=$registered->title?></td>
        <td><?=$registered->first_name." ".$registered->last_name?></td>
        <td><?=$registered->position?></td>
        <td><?=$registered->org_name?></td>
        <td><?=$registered->telephone?></td>
        <td><?=$registered->email?></td>
    </tr>
    <?php
        }
        ?>
</table>
</div>
<!----------------- dispay only ---------------------->
<table class="table table-bordered">
    <tr style="background-color:#5588D9;color:#ffffff;">
        <th><?=Yii::t('app','No.')?></th>
        <th><?=Yii::t('app','Title Persion')?></th>
        <th><?=Yii::t('app','Name')?></th>
        <th><?=Yii::t('app','Position')?></th>
        <th><?=Yii::t('app','Organization')?></th>
        <th><?=Yii::t('app','Telephone')?></th>
        <th><?=Yii::t('app','Email')?></th>
        <th></th>
    </tr>
    <?php
        $i=0;
        foreach ($model as $registered) {
            $i++;
        ?>
    <tr>
        <td><?=$i?></td>
        <td><?=$registered->title?></td>
        <td><?=$registered->first_name." ".$registered->last_name?></td>
        <td><?=$registered->position?></td>
        <td><?=$registered->org_name?></td>
        <td><?=$registered->telephone?></td>
        <td><?=$registered->email?></td>
        <td style="width:90px;">
            <?php
                 echo Html::a('<span class="glyphicon glyphicon-edit" style="color: white;"></span>', ['registerdit', 'id' => $registered->id,'reg_id'=>(int)$_GET['id']], ['class' => 'btn btn-success btn-sm']);
                 echo Html::a('<span class="glyphicon glyphicon-remove" style="color: white;"></span>', ['registdel', 'id' => $registered->id,'reg_id'=>(int)$_GET['id']], ['onclick'=>"return confirm('".Yii::t('app','Make sure you want to delete this item.?')."')",'class' => 'btn btn-danger btn-sm']);
                           
             ?>
        </td>
    </tr>
    <?php
        }
        ?>
</table>