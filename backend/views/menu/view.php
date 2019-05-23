<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Menu */

$this->title = Yii::t('app', 'View Menu');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'View');
$setting = Yii::$app->session["setting"];
?>
<div class="menu-view">
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'link',
            [
                'attribute' => 'content_id',
                'value' => isset($model->content) ? $model->content->title : "",
            ],
            [
                'attribute' => 'menu_id',
                'value' => isset($model->menu) ? $model->menu->name : "",
            ],
            [
                'attribute' => 'status',
                'value' => $model->status == 0 ? Yii::t("app", "Inactive") : Yii::t("app", "Active"),
            ],
            [
                'attribute' => 'created_date',
                'value' => isset($model->created_date) ? date('d/m/Y H:i:s', strtotime($model->created_date)) : "",
            ],
            [
                'attribute' => 'created_by',
                'value' => isset($model->created_by) ? $model->createdBy->full_name : "",
            ],
            [
                'attribute' => 'updated_date',
                'value' => isset($model->updated_date) ? date('d/m/Y H:i:s', strtotime($model->updated_date)) : "",
            ],
            [
                'attribute' => 'updated_by',
                'value' => isset($model->updated_by) ? $model->updatedBy->full_name : "",
            ],
            [
                'attribute' => 'top',
                'format' => 'ntext',
                'value' => $model->top == 0 ? Yii::t("app", "Yes") : Yii::t("app", "No"),
                'visible' => ($setting->has_menu_top) ? TRUE : FALSE,
            ],
            [
                'attribute' => 'bottom',
                'format' => 'ntext',
                'value' => $model->bottom == 0 ? Yii::t("app", "Yes") : Yii::t("app", "No"),
                'visible' => ($setting->has_menu_bottom) ? TRUE : FALSE,
            ],
            [
                'attribute' => 'left',
                'format' => 'ntext',
                'value' => $model->left == 0 ? Yii::t("app", "Yes") : Yii::t("app", "No"),
                'visible' => ($setting->has_menu_left) ? TRUE : FALSE,
            ],
            [
                'attribute' => 'right',
                'format' => 'ntext',
                'value' => $model->right == 0 ? Yii::t("app", "Yes") : Yii::t("app", "No"),
                'visible' => ($setting->has_menu_right) ? TRUE : FALSE,
            ],
        ],
    ])
    ?>

</div>
