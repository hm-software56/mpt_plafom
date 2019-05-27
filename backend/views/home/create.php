<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Home */

$this->title = Yii::t('app', 'Create Home');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Homes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="home-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
