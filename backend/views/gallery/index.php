<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\GallerySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Galleries');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-index">
    <?php
    $user = Yii::$app->session["currentUser"];
    if ($user->checkAccess($user->type, "/gallery", "create") == 1) {
        ?>
        <p align="right">
            <?= Html::a('<span class="fa fa-plus"></span> ' . Yii::t('app', 'Create Gallery'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php } ?>
    <?php Pjax::begin(); ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'title',
            [
                'attribute' => 'photo',
                'format' => 'raw',
                'value' => function ($data) {
                    $url = \Yii::$app->request->BaseUrl . '/images/' . Yii::$app->params['downloadFilePath'] . "/" . $data->photo;
                    return Html::img($url, ['title' => $data->title, 'class' => 'img-responsive img-fluid']);
                },
                    'filter' => false
                ],
                'sort',
                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => function ($data) {
                        return ($data->status == 1) ? '<span class="label label-success">' . Yii::t('app', 'Active') . '</span>' : '<span class="label label-danger">' . Yii::t('app', 'Inactive') . '</span>';
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'status', [1 => Yii::t('app', 'Active'), 0 => Yii::t('app', 'Inactive')], ['class' => 'form-control', 'prompt' => '']),
                ],
                [
                    'attribute' => 'date',
                    'format' => 'html',
                    'value' => function ($data) {
                        return empty($data->date) ? "" : date('d/m/Y', strtotime($data->date));
                    },
                    'filter' => \yii\jui\DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'date',
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => ['class' => 'form-control']
                    ]),
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete} {activate} {deactivate}',
                    'visibleButtons' => [
                        'activate' => function ($model, $key, $index) {
                            $user = Yii::$app->session["currentUser"];
                            return (($model->status == 0) && ($user->checkAccess($user->type, "/gallery", "activate") == 1)) ? true : false;
                        },
                        'deactivate' => function ($model, $key, $index) {
                            $user = Yii::$app->session["currentUser"];
                            return (($model->status == 1) && ($user->checkAccess($user->type, "/gallery", "deactivate") == 1)) ? true : false;
                        },
                        'update' => function ($model, $key, $index) {
                            $user = Yii::$app->session["currentUser"];
                            return (($user->checkAccess($user->type, "/gallery", "update") == 0)) ? false : true;
                        },
                        'delete' => function ($model, $key, $index) {
                            $user = Yii::$app->session["currentUser"];
                            return (($user->checkAccess($user->type, "/gallery", "delete") == 0)) ? false : true;
                        },
                        'view' => function ($model, $key, $index) {
                            $user = Yii::$app->session["currentUser"];
                            return (($user->checkAccess($user->type, "/gallery", "view") == 0)) ? false : true;
                        }
                    ],
                    'buttons' => [
                        'deactivate' => function ($url, $model) {
                            return Html::a(
                                    '<span class="glyphicon glyphicon-off"></span>', ['gallery/deactivate', 'id' => $model->id], [
                                    'class' => 'btn btn-danger btn-xs btn-marg', 'title' => Yii::t('app', 'Deactivate')
                                    ]
                            );
                        },
                            'activate' => function ($url, $model) {
                            return Html::a(
                                    '<span class="glyphicon glyphicon-ok"></span>', ['gallery/activate', 'id' => $model->id], [
                                    'class' => 'btn btn-success btn-xs btn-marg', 'title' => Yii::t('app', 'Activate')
                                    ]
                            );
                        },
                            'view' => function ($url, $model) {
                            return Html::a('<span class = "glyphicon glyphicon-eye-open"></span>', $url, [
                                    'title' => Yii::t("app", "View"),
                                    'class' => 'btn btn-primary btn-xs btn-marg',
                            ]);
                        },
                            'update' => function ($url, $model) {
                            return Html::a(
                                    '<span class="glyphicon glyphicon-edit"></span>', ['gallery/update', 'id' => $model->id], [
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
