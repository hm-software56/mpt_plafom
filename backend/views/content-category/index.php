<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ContentCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Content Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-category-index">
    <?php
    $user = Yii::$app->session["currentUser"];
    if ($user->checkAccess($user->type, "/content-category", "create") == 1) {
        ?>
        <p align="right">
            <?= Html::a('<span class="fa fa-plus"></span> ' . Yii::t('app', 'Create Content Category'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php } ?>
    <?php Pjax::begin(); ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'title',
            [
                'attribute' => 'has_summary',
                'format' => 'html',
                'value' => function ($data) {
                    return ($data->has_summary == 1) ? '<span class="label label-success">' . Yii::t('app', 'Yes') . '</span>' : '<span class="label label-danger">' . Yii::t('app', 'No') . '</span>';
                },
                'filter' => Html::activeDropDownList($searchModel, 'has_summary', [1 => Yii::t('app', 'Yes'), 0 => Yii::t('app', 'No')], ['class' => 'form-control', 'prompt' => '']),
            ],
            [
                'attribute' => 'has_details',
                'format' => 'html',
                'value' => function ($data) {
                    return ($data->has_details == 1) ? '<span class="label label-success">' . Yii::t('app', 'Yes') . '</span>' : '<span class="label label-danger">' . Yii::t('app', 'No') . '</span>';
                },
                'filter' => Html::activeDropDownList($searchModel, 'has_details', [1 => Yii::t('app', 'Yes'), 0 => Yii::t('app', 'No')], ['class' => 'form-control', 'prompt' => '']),
            ],
            [
                'attribute' => 'has_photo',
                'format' => 'html',
                'value' => function ($data) {
                    return ($data->has_photo == 1) ? '<span class="label label-success">' . Yii::t('app', 'Yes') . '</span>' : '<span class="label label-danger">' . Yii::t('app', 'No') . '</span>';
                },
                'filter' => Html::activeDropDownList($searchModel, 'has_photo', [1 => Yii::t('app', 'Yes'), 0 => Yii::t('app', 'No')], ['class' => 'form-control', 'prompt' => '']),
            ],
            [
                'attribute' => 'is_legal_type',
                'format' => 'html',
                'value' => function ($data) {
                    return ($data->is_legal_type == 1) ? '<span class="label label-success">' . Yii::t('app', 'Yes') . '</span>' : '<span class="label label-danger">' . Yii::t('app', 'No') . '</span>';
                },
                'filter' => Html::activeDropDownList($searchModel, 'is_legal_type', [1 => Yii::t('app', 'Yes'), 0 => Yii::t('app', 'No')], ['class' => 'form-control', 'prompt' => '']),
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($data) {
                    return ($data->status == 1) ? '<span class="label label-success">' . Yii::t('app', 'Active') . '</span>' : '<span class="label label-danger">' . Yii::t('app', 'Inactive') . '</span>';
                },
                'filter' => Html::activeDropDownList($searchModel, 'status', [1 => Yii::t('app', 'Active'), 0 => Yii::t('app', 'Inactive')], ['class' => 'form-control', 'prompt' => '']),
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {activate} {deactivate}',
                'visibleButtons' => [
                    'activate' => function ($model, $key, $index) {
                        $user = Yii::$app->session["currentUser"];
                        return (($model->status == 0) && ($user->checkAccess($user->type, "/content-category", "activate") == 1)) ? true : false;
                    },
                    'deactivate' => function ($model, $key, $index) {
                        $user = Yii::$app->session["currentUser"];
                        return (($model->status == 1) && ($user->checkAccess($user->type, "/content-category", "deactivate") == 1)) ? true : false;
                    },
                    'update' => function ($model, $key, $index) {
                        $user = Yii::$app->session["currentUser"];
                        return (($user->checkAccess($user->type, "/content-category", "update") == 0)) ? false : true;
                    },
                    'delete' => function ($model, $key, $index) {
                        $user = Yii::$app->session["currentUser"];
                        return (($user->checkAccess($user->type, "/content-category", "delete") == 0)) ? false : true;
                    },
                    'view' => function ($model, $key, $index) {
                        $user = Yii::$app->session["currentUser"];
                        return (($user->checkAccess($user->type, "/content-category", "view") == 0)) ? false : true;
                    }
                ],
                'buttons' => [
                    'deactivate' => function ($url, $model) {
                        return Html::a(
                                '<span class="glyphicon glyphicon-off"></span>', ['content-category/deactivate', 'id' => $model->id], [
                                'class' => 'btn btn-danger btn-xs btn-marg', 'title' => Yii::t('app', 'Deactivate')
                                ]
                        );
                    },
                        'activate' => function ($url, $model) {
                        return Html::a(
                                '<span class="glyphicon glyphicon-ok"></span>', ['content-category/activate', 'id' => $model->id], [
                                'class' => 'btn btn-success btn-xs btn-marg', 'title' => Yii::t('app', 'Activate')
                                ]
                        );
                    },
                        'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', '#', [
                                'title' => Yii::t("app", "View"),
                                'onclick' => "$('#detail-modal').modal('show');
                                    $.ajax({
                                       type: 'GET',
                                       cache: false,
                                       url: '" . Yii::$app->urlManager->createUrl(['content-category/view', 'id' => $model->id]) . "',
                                                success: function(response) {
                                                      $('#detail-modal .modal-body').html(response);
                                                },
                                            });
                                            return false;
                                          ",
                                'class' => 'btn btn-primary btn-xs btn-marg',
                        ]);
                    },
                        'update' => function ($url, $model) {
                        return Html::a(
                                '<span class="glyphicon glyphicon-edit"></span>', ['content-category/update', 'id' => $model->id], [
                                'title' => Yii::t("app", "Update"),
                                'data-pjax' => "0",
                                'class' => 'btn btn-success btn-xs btn-marg',
                                ]
                        );
                    },
                        'delete' => function ($url, $model) {
                        return Html::a(
                                '<span class="glyphicon glyphicon-remove"></span>', $url, [
                                'title' => Yii::t("app", "Delete"),
                                'data-pjax' => '0',
                                'data-method' => "post",
                                'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'class' => 'btn btn-danger btn-xs btn-marg',
                                ]
                        );
                    },
                    ],
                //'contentOptions' => ['style' => 'width: 20px'],
                ],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?></div>

    <?php
    Modal::begin(['clientOptions' => ['keyboard' => false], 'options' => ['id' => 'detail-modal',]])
    ?>
    <div id='modalContent' style="z-index:999999;"></div>
    <?php yii\bootstrap\Modal::end() ?>