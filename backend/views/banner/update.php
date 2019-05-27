<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Banner */

$this->title = Yii::t('app', 'Change Banner', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = Yii::t('app', 'Banner');
?>
<div class="banner-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
