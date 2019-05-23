<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\event\models\Event */

$this->title = Yii::t('app', 'ສ້າງ ກອງ​ປະ​ຊ​ຸມ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
