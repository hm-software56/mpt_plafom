<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Video */

/* $this->title = Yii::t('app', 'Update {modelClass}: ', [
  'modelClass' => 'Video',
  ]) . $model->title; */
$this->title = Yii::t('app', 'Update Video');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Videos'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="video-update">

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
