<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Issue */

$this->title = Yii::t('app', 'Create Issue');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Issues'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="issue-create">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
