<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SliderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sliders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>
    <?php
    $user = Yii::$app->session["currentUser"];
    if ($user->checkAccess($user->type, "/slider", "create") == 1) {
        ?>
        <p align='right'>
            <?= Html::a('<span class="fa fa-plus"></span> ' . Yii::t('app', 'Create Slider'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php } ?>
    <?php Pjax::begin(); ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'photo',
                'format' => 'html',
                'value' => function($data) {
                    if ($data['photo'] != "") {
                        return Html::img(\Yii::$app->request->BaseUrl . '/images/' . Yii::$app->params['downloadFilePath'] . "/" . $data['photo'], ['class' => 'img-responsive']);
                    } else
                        return '';
                }
                ],
                'title',
                'link',
                //'details:html',
                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => function ($data) {
                        return ($data->status == 1) ? '<span class="label label-success">' . Yii::t('app', 'Active') . '</span>' : '<span class="label label-danger">' . Yii::t('app', 'Inactive') . '</span>';
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'status', [1 => Yii::t('app', 'Active'), 0 => Yii::t('app', 'Inactive')], ['class' => 'form-control', 'prompt' => '']),
                ],
                // 'sort',
                // 'status',
                // 'created_date',
                // 'updated_date',
                // 'created_by',
                // 'updated_by',
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete} {activate} {deactivate}',
                    'visibleButtons' => [
                        'activate' => function ($model, $key, $index) {
                            $user = Yii::$app->session["currentUser"];
                            return (($model->status == 0) && ($user->checkAccess($user->type, "/slider", "activate") == 1)) ? true : false;
                        },
                        'deactivate' => function ($model, $key, $index) {
                            $user = Yii::$app->session["currentUser"];
                            return (($model->status == 1) && ($user->checkAccess($user->type, "/slider", "deactivate") == 1)) ? true : false;
                        },
                        'update' => function ($model, $key, $index) {
                            $user = Yii::$app->session["currentUser"];
                            return (($user->checkAccess($user->type, "/slider", "update") == 0)) ? false : true;
                        },
                        'delete' => function ($model, $key, $index) {
                            $user = Yii::$app->session["currentUser"];
                            return (($user->checkAccess($user->type, "/slider", "delete") == 0)) ? false : true;
                        },
                        'view' => function ($model, $key, $index) {
                            $user = Yii::$app->session["currentUser"];
                            return (($user->checkAccess($user->type, "/slider", "view") == 0)) ? false : true;
                        }
                    ],
                    'buttons' => [
                        'deactivate' => function ($url, $model) {
                            return Html::a(
                                    '<span class="glyphicon glyphicon-off"></span>', ['slider/deactivate', 'id' => $model->id], [
                                    'class' => 'btn btn-danger btn-xs btn-marg', 'title' => Yii::t('app', 'Deactivate')
                                    ]
                            );
                        },
                            'activate' => function ($url, $model) {
                            return Html::a(
                                    '<span class="glyphicon glyphicon-ok"></span>', ['slider/activate', 'id' => $model->id], [
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
                                       url: '" . Yii::$app->urlManager->createUrl(['slider/view', 'id' => $model->id]) . "',
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
                                    '<span class="glyphicon glyphicon-edit"></span>', ['slider/update', 'id' => $model->id], [
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

