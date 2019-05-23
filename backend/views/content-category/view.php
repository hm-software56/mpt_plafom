<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ContentCategory */

$this->title = Yii::t('app', 'View Content Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Content Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'View');
?>
<div class="content-category-view">
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
                'attribute' => 'has_summary',
                'value' => $model->has_summary == 0 ? Yii::t("app", "Yes") : Yii::t("app", "No"),
            ],
            [
                'attribute' => 'has_details',
                'value' => $model->has_details == 0 ? Yii::t("app", "Yes") : Yii::t("app", "No"),
            ],
            [
                'attribute' => 'has_photo',
                'value' => $model->has_photo == 0 ? Yii::t("app", "Yes") : Yii::t("app", "No"),
            ],
            [
                'attribute' => 'has_keywords',
                'value' => $model->has_photo == 0 ? Yii::t("app", "Yes") : Yii::t("app", "No"),
            ],
            [
                'attribute' => 'has_meta_keywords',
                'value' => $model->has_photo == 0 ? Yii::t("app", "Yes") : Yii::t("app", "No"),
            ],
            [
                'attribute' => 'has_start_date',
                'value' => $model->has_photo == 0 ? Yii::t("app", "Yes") : Yii::t("app", "No"),
            ],
            [
                'attribute' => 'has_end_date',
                'value' => $model->has_photo == 0 ? Yii::t("app", "Yes") : Yii::t("app", "No"),
            ],
            [
                'attribute' => 'has_multi_attachment',
                'value' => $model->has_photo == 0 ? Yii::t("app", "Yes") : Yii::t("app", "No"),
            ],
            [
                'attribute' => 'is_legal_type',
                'value' => $model->is_legal_type == 0 ? Yii::t("app", "Yes") : Yii::t("app", "No"),
            ],
            [
                'attribute' => 'status',
                'value' => $model->status == 0 ? Yii::t("app", "Inactive") : Yii::t("app", "Active"),
            ],
            [
                'attribute' => 'created_date',
                'value' => isset($model->created_date) ? date('d/m/Y', strtotime($model->created_date)) : "",
            ],
            [
                'attribute' => 'created_by',
                'value' => isset($model->created_by) ? $model->createdBy->full_name : "",
            ],
            [
                'attribute' => 'updated_date',
                'value' => isset($model->updated_date) ? date('d/m/Y', strtotime($model->updated_date)) : "",
            ],
            [
                'attribute' => 'updated_by',
                'value' => isset($model->updated_by) ? $model->updatedBy->full_name : "",
            ],
        ],
    ])
    ?>

</div>
