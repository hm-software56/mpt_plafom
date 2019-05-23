<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\IssueCategory */

$this->title = Yii::t('app', 'Update Issue Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Issue Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="issue-category-update">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
