<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use backend\modules\event\models\Event;
/* @var $this yii\web\View */
/* @var $model backend\modules\event\models\Event */
$this->title = $model->event_title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
      function printContent(el)
      {
         var restorepage = document.body.innerHTML;
         var printcontent = document.getElementById(el).innerHTML;
         document.body.innerHTML = printcontent;
         window.print();
         document.body.innerHTML = restorepage;
     }
   </script>
   <?php
     echo Html::a('<span class="glyphicon glyphicon-backward" style="color: white;"></span> '.Yii::t('app','Back').'', ['view', 'id' => $list->event_id], ['class' => 'btn btn-primary']);
   ?>
   <button class="btn btn-danger" onclick="printContent('print')"><span class="glyphicon glyphicon-print" style="color: white;"></span> <?=Yii::t('app','Print')?></button>
   
<div class="event-view" id="print">
<?php
if (!empty($list)) {
?>
    <table class="table table-bordered">
        <tr>
            <th><?=Yii::t('app', 'QR Code')?></th>
            <th><?=Yii::t('app', 'org_name1')?></th>
            <th><?=Yii::t('app', 'org_name2')?></th>
            <th><?=Yii::t('app', 'pax')?></th>
        </tr>
        <tr>
            <td>
                <img src="<?=Yii::$app->urlManager->baseUrl?>/imgqrcode/<?=$list->registration_code?>.png"/>
            </td>
            <td><?=$list->org_name1?></td>
            <td><?=$list->org_name2?></td>
            <td><?=$list->pax?></td>
        </tr>
    </table>
<?php
}
?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'event_title',
            'agenda:ntext',
            'date_start',
            'time_start',
            'date_end',
            'time_end',
            'location',
            'host',
            'contract',
            'register_deadline',
        ],
    ]) ?>
<br/>
<style>
iframe{
    width:990px !important;
}
img { 
    max-width: none !important; 
} 
@media print {
  img {
    max-width: none !important;
  }
}

</style>
<button onclick="myFunction()">Print this page</button>

<script>
function myFunction() {
window.print();
}
</script>
<?=$model->map?>
</div>
