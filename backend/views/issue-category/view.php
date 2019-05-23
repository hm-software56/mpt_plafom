<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\IssueCategory */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Issue Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="issue-category-view">
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
        ],
    ])
    ?>

</div>
