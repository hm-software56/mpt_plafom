<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Home */

$this->title = Yii::t('app', 'Update Home: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Homes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="home-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
