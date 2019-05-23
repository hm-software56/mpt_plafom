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
<div class="event-view">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
    <?php
        echo Html::a('<span class="glyphicon glyphicon-backward" style="color: white;"></span> '.Yii::t('app','Back').'', ['index'], ['class' => 'btn btn-primary']);
    ?>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" align="right">
    <?php
        echo yii\helpers\Html::a('<span class="glyphicon glyphicon-plus" style="color: white;"></span> '.Yii::t('app','Add invitation').'', '#', [
            'onclick' => "
            $.ajax({
            type     :'POST',
            cache    : false,
            url  : 'index.php?r=event/event/invitcreate&rg_id=" . $model->id . "',
            success  : function(response) {
                $('#output').html(response);
                document.getElementById('search').focus();
            }
            });return false;",
            'class'=>'btn btn-success',
        ]);
    ?>
</div>
<?php
if (!empty($invitationlist)) {
?>
    <table class="table table-bordered">
        <tr>
            <th><?=Yii::t('app', 'QR Code')?></th>
            <th><?=Yii::t('app', 'org_name1')?></th>
            <th><?=Yii::t('app', 'org_name1')?></th>
            <th><?=Yii::t('app', 'pax')?></th>
           
        </tr>
        <?php
            foreach($invitationlist as $list)
            {
                ?>
                <tr>
                    <td>
                        <img src="<?=Yii::$app->urlManager->baseUrl?>/imgqrcode/<?=$list->registration_code?>.png" width="50"/>
                    </td>
                    <td><?=$list->org_name1?></td>
                    <td><?=$list->org_name2?></td>
                    <td><?=$list->pax?></td>
                    <td style="width:130px;">
                        <?php
                        echo Html::a('<span class="glyphicon glyphicon-print" style="color: white;"></span>', ['viewprint', 'id' => $list->id], ['class' => 'btn btn-primary btn-sm','target'=>"_blank"]);
    
                        echo yii\helpers\Html::a('<span class="glyphicon glyphicon-edit" style="color: white;"></span>', '#', [
                                'onclick' => "
                                $.ajax({
                                type     :'POST',
                                cache    : false,
                                url  : 'index.php?r=event/event/invitedit&id=" . $list->id . "',
                                success  : function(response) {
                                    $('#output').html(response);
                                }
                                });return false;",
                                'class'=>'btn btn-success btn-sm',
                            ]);
                        ?>
                        <?php
                            echo yii\helpers\Html::a('<span class="glyphicon glyphicon-remove" style="color: white;"></span>', '#', [
                                'onclick' => "
                                if (confirm('".Yii::t('app','​ຖ້າ​ທ່ານ​ລືບ​ລາຍ​ການນີ້​ຂໍ້​ມູນ​ກ​່ຽວ​ກັບ​ລາຍ​ການນີ້​ຈະ​ຖືກ​ລືບ​ໄປ​ນຳ.?')."')) {
                                $.ajax({
                                type     :'POST',
                                cache    : false,
                                url  : 'index.php?r=event/event/invitdelete&id=" . $list->id . "',
                                success  : function(response) {
                                    $('#output').html(response);
                                }
                                });return false;
                                }",
                                'class'=>'btn btn-danger btn-sm',
                            ]);
                        ?>
                    </td>
                </tr>
                <?php
            }
        ?>
    </table>
<?php
}
?>
<div id="output"></div>
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
</div>
<style>
iframe{
    width:100% !important;
}
</style>
<?=$model->map?>