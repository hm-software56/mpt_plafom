<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use backend\modules\event\models\Event;
/* @var $this yii\web\View */
/* @var $model backend\modules\event\models\Event */
//$this->title = $model->event_title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>

<script>
function myFunction() {
    var x = document.getElementById("myDIV");
    x.style.display = "none";
    window.print();
    window.close();
}
</script>
<div align="right" id="myDIV">
   <button class="btn btn-danger" onclick="myFunction()"><span class="glyphicon glyphicon-print" style="color: white;"></span> <?=Yii::t('app','Print')?></button>
</div>
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
<?=$model->map?>
</div>
