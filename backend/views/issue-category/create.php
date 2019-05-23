<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\IssueCategory */

$this->title = Yii::t('app', 'Create Issue Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Issue Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="issue-category-create">

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
