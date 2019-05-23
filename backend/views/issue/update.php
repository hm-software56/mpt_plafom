<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Issue */

$this->title = Yii::t('app', 'Update Issue');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Issues'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="issue-update">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
