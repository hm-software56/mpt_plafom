<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Menus');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">
    <?php
    $user = Yii::$app->session["currentUser"];
    if ($user->checkAccess($user->type, "/menu", "create") == 1) {
        ?>
        <p align="right">
            <?= Html::a('<span class="fa fa-plus"></span> ' . Yii::t('app', 'Create Menu'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php } ?>
    <?php
    Pjax::begin();
    $setting = null;
    if (isset(Yii::$app->session["setting"])) {
        $setting = Yii::$app->session["setting"];
    }
    ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            [
                'attribute' => 'menu_id',
                'format' => 'html',
                'value' => function($data) {
                    return empty($data->menu->name) ? "" : $data->menu->name;
                },
                'filter' => Html::activeDropDownList($searchModel, 'menu_id', ArrayHelper::map(backend\models\Menu::getList(), 'id', 'name'), ['class' => 'form-control', 'prompt' => '']),
            ],
            'link',
            [
                'attribute' => 'content_id',
                'format' => 'html',
                'value' => function ($data) {
                    return empty($data->content->title) ? "" : $data->content->title;
                },
                'filter' => Html::activeDropDownList($searchModel, 'content_id', ArrayHelper::map(backend\models\Content::getList(), 'id', 'title'), ['class' => 'form-control', 'prompt' => '']),
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($data) {
                    return ($data->status == 1) ? '<span class="label label-success">' . Yii::t('app', 'Active') . '</span>' : '<span class="label label-danger">' . Yii::t('app', 'Inactive') . '</span>';
                },
                'filter' => Html::activeDropDownList($searchModel, 'status', [1 => Yii::t('app', 'Active'), 0 => Yii::t('app', 'Inactive')], ['class' => 'form-control', 'prompt' => '']),
            ],
            [
                'attribute' => 'top',
                'format' => 'html',
                'value' => function ($data) {
                    return ($data->top == 1) ? '<span class="label label-success">' . Yii::t('app', 'Yes') . '</span>' : '<span class="label label-danger">' . Yii::t('app', 'No') . '</span>';
                },
                'filter' => Html::activeDropDownList($searchModel, 'top', [1 => Yii::t('app', 'Yes'), 0 => Yii::t('app', 'No')], ['class' => 'form-control', 'prompt' => '']),
                'visible' => $setting->has_menu_top,
            ],
            [
                'attribute' => 'left',
                'format' => 'html',
                'value' => function ($data) {
                    return ($data->left == 1) ? '<span class="label label-success">' . Yii::t('app', 'Yes') . '</span>' : '<span class="label label-danger">' . Yii::t('app', 'No') . '</span>';
                },
                'filter' => Html::activeDropDownList($searchModel, 'left', [1 => Yii::t('app', 'Yes'), 0 => Yii::t('app', 'No')], ['class' => 'form-control', 'prompt' => '']),
                'visible' => $setting->has_menu_left,
            ],
            [
                'attribute' => 'right',
                'format' => 'html',
                'value' => function ($data) {
                    return ($data->right == 1) ? '<span class="label label-success">' . Yii::t('app', 'Yes') . '</span>' : '<span class="label label-danger">' . Yii::t('app', 'No') . '</span>';
                },
                'filter' => Html::activeDropDownList($searchModel, 'right', [1 => Yii::t('app', 'Yes'), 0 => Yii::t('app', 'No')], ['class' => 'form-control', 'prompt' => '']),
                'visible' => $setting->has_menu_right,
            ],
            [
                'attribute' => 'bottom',
                'format' => 'html',
                'value' => function ($data) {
                    return ($data->bottom == 1) ? '<span class="label label-success">' . Yii::t('app', 'Yes') . '</span>' : '<span class="label label-danger">' . Yii::t('app', 'No') . '</span>';
                },
                'filter' => Html::activeDropDownList($searchModel, 'bottom', [1 => Yii::t('app', 'Yes'), 0 => Yii::t('app', 'No')], ['class' => 'form-control', 'prompt' => '']),
                'visible' => $setting->has_menu_bottom,
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{sub} {view} {update} {delete} {activate} {deactivate}',
                'visibleButtons' => [
                    'sub' => function ($model, $key, $index) {
                        $user = Yii::$app->session["currentUser"];
                        return (backend\models\Menu::showSubbutton($model->id) && ($user->checkAccess($user->type, "/menu", "create") == 1)) ? true : false;
                    },
                    'activate' => function ($model, $key, $index) {
                        $user = Yii::$app->session["currentUser"];
                        return (($model->status == 0) && ($user->checkAccess($user->type, "/menu", "activate") == 1)) ? true : false;
                    },
                    'deactivate' => function ($model, $key, $index) {
                        $user = Yii::$app->session["currentUser"];
                        return (($model->status == 1) && ($user->checkAccess($user->type, "/menu", "deactivate") == 1)) ? true : false;
                    },
                    'update' => function ($model, $key, $index) {
                        $user = Yii::$app->session["currentUser"];
                        return (($user->checkAccess($user->type, "/menu", "update") == 0)) ? false : true;
                    },
                    'delete' => function ($model, $key, $index) {
                        $user = Yii::$app->session["currentUser"];
                        return (($user->checkAccess($user->type, "/menu", "delete") == 0)) ? false : true;
                    },
                    'view' => function ($model, $key, $index) {
                        $user = Yii::$app->session["currentUser"];
                        return (($user->checkAccess($user->type, "/menu", "view") == 0)) ? false : true;
                    }
                ],
                'buttons' => [
                    'deactivate' => function ($url, $model) {
                        return Html::a(
                                        '<span class="glyphicon glyphicon-off"></span>', ['menu/deactivate', 'id' => $model->id], [
                                    'class' => 'btn btn-danger btn-xs btn-marg', 'title' => Yii::t('app', 'Deactivate')
                                        ]
                        );
                    },
                            'activate' => function ($url, $model) {
                        return Html::a(
                                        '<span class="glyphicon glyphicon-ok"></span>', ['menu/activate', 'id' => $model->id], [
                                    'class' => 'btn btn-success btn-xs btn-marg', 'title' => Yii::t('app', 'Activate')
                                        ]
                        );
                    },
                            'sub' => function ($url, $model) {
                        return Html::a(
                                        '<span class="glyphicon glyphicon-plus"></span>', ['menu/create', 'parent' => $model->id], [
                                    'title' => Yii::t("app", "Add sub menu"),
                                    'data-pjax' => "0",
                                    'class' => 'btn btn-primary btn-xs btn-marg',
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
                                       url: '" . Yii::$app->urlManager->createUrl(['menu/view', 'id' => $model->id]) . "',
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
                                        '<span class="glyphicon glyphicon-edit"></span>', ['menu/update', 'id' => $model->id], [
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
