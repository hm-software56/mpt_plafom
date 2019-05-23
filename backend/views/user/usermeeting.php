<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <?php
    $user = Yii::$app->session["currentUser"];
    if ($user->checkAccess($user->type, "/user", "create") == 1) {
        ?>
        <p align = "right">
            <?= Html::a('<span class="fa fa-plus"></span> ' . Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success', 'title' => Yii::t('app', 'Create User')]) ?>
        </p>
    <?php } ?>
    <?php
    //Pjax::begin();
    ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'full_name',
                'label'=>'Organization'
            ],
            'username',
            [
                'attribute' => 'type',
                'format' => 'html',
                'value' => function ($data) {
                    return empty($data->type) ? "" : Yii::t('app', $data->type);
                },
                'filter' => Html::activeDropDownList($searchModel, 'type', ArrayHelper::map(backend\models\User::getAllRoles(), 'id', 'name'), ['class' => 'form-control', 'prompt' => '']),
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
                'template' => '{activate} {deactivate} {update} {delete}',
                'visibleButtons' => [
                    'delete' => function ($model, $key, $index) {
                        $user = Yii::$app->session["currentUser"];
                        return ($user->checkAccess($user->type, "/user", "delete") == 0) ? false : true;
                    },
                    'activate' => function ($model, $key, $index) {
                        $user = Yii::$app->session["currentUser"];
                        return ($model->status == 0 && $user->checkAccess($user->type, "/user", "activate") == 1) ? true : false;
                    },
                    'deactivate' => function ($model, $key, $index) {
                        $user = Yii::$app->session["currentUser"];
                        return ($model->status == 1 && ($user->checkAccess($user->type, "/user", "deactivate") == 1)) ? true : false;
                    },
                    'update' => function ($model, $key, $index) {
                        $user = Yii::$app->session["currentUser"];
                        return (($user->checkAccess($user->type, "/user", "update") == 0)) ? false : true;
                    }
                ],
                'buttons' => [
                    'deactivate' => function ($url, $model) {
                        return Html::a(
                                        '<span class="glyphicon glyphicon-off"></span>', ['user/deactivate', 'id' => $model->id], [
                                    'class' => 'btn btn-danger btn-xs btn-marg', 'title' => Yii::t('app', 'Deactivate')
                                        ]
                        );
                    },
                            'activate' => function ($url, $model) {
                        return Html::a(
                                        '<span class="glyphicon glyphicon-ok"></span>', ['user/activate', 'id' => $model->id], [
                                    'class' => 'btn btn-success btn-xs btn-marg', 'title' => Yii::t('app', 'Activate')
                                        ]
                        );
                    },
                            'update' => function ($url, $model) {
                        return Html::a(
                                        '<span class="glyphicon glyphicon-edit"></span>', ['user/update', 'id' => $model->id], [
                                    'class' => 'btn btn-success btn-xs btn-marg', 'title' => Yii::t('app', 'Update')
                                        ]
                        );
                    },
                            'delete' => function ($url, $model) {
                        return Html::a(
                                        '<span class="glyphicon glyphicon-remove"></span>', $url, [
                                    'title' => Yii::t('app', 'Delete'),
                                    'data-pjax' => '0',
                                    'data-method' => "post",
                                    'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                    'class' => 'btn btn-danger btn-xs btn-marg',
                                        ]
                        );
                    },
                        ],
                    //'contentOptions' => [ 'style' => 'width: 20px'],
                    ],
                ],
            ]);
            ?>
            <?php //Pjax::end();  ?></div>
