<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Issue */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Issues'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="issue-view">
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'file',
                'format' => 'html',
                'value' => isset($model->file) && !empty($model->file) ? Html::a(Yii::t('app', 'Download'), ['/site/download', 'file' => $model->file]) : "",
            ],
            'name',
            'email:email',
            'telephone',
            [
                'attribute' => 'issue_category_id',
                'value' => isset($model->issueCategory) ? $model->issueCategory->title : "",
            ],
            'subject',
            'message:ntext',
            [
                'attribute' => 'created_date',
                'value' => isset($model->created_date) ? date('d/m/Y H:i:s', strtotime($model->created_date)) : "",
            ],
        ],
    ])
    ?>

</div>
