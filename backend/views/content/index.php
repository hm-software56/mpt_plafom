<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = \backend\models\ContentCategory::findOne(Yii::$app->session['type'])->title;
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index', 'type' => Yii::$app->session['type']]];
?>
<div class="content-index">
    <?php
    $user = Yii::$app->session["currentUser"];
    if ($user->checkAccess($user->type, "/content", "create") == 1) {
		if(Yii::$app->session['type']!=11)
			{
			?>
			<p align="right">
				<?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('app', 'Create') . " " . $this->title, ['create', 'type' => Yii::$app->session['type']], ['class' => 'btn btn-success']) ?>
			</p>
			<?php
			}
		} ?>
    <?php Pjax::begin(); ?>
    <?php
    $label = Yii::t("app", "Start Date");
    $contentcategory = \backend\models\ContentCategory::findOne(Yii::$app->session['type']);
    if (isset($contentcategory)) {
        if ($contentcategory->has_start_date) {
            $label = Yii::t("app", "Start Date");
            if (!$contentcategory->has_end_date) {
                $label = Yii::t("app", "Date");
            }
        }
    }
    ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'title',
            [
                'attribute' => 'photo',
                'format' => 'raw',
                'value' => function($data) {
                    $url = \Yii::$app->request->BaseUrl . '/images/' . Yii::$app->params['downloadFilePath'] . '/' . $data->photo;
                    return Html::img($url, ['title' => $data->title, 'class' => 'img-responsive img-fluid','style'=>'width:150px;']);
                },
                    'filter' => false,
                    'visible' => $contentcategory->has_photo,
                ],
                [
                    'attribute' => 'start_date',
                    'label' => $label,
                    'format' => 'html',
                    'value' => function ($data) {
                        return empty($data->start_date) ? "" : date('d/m/Y', strtotime($data->start_date));
                    },
                    'filter' => \yii\jui\DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'start_date',
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => ['class' => 'form-control']
                    ]),
                    'visible' => $contentcategory->has_start_date,
                ],
                ['attribute' => 'end_date',
                    'format' => 'html',
                    'value' => function($data) {
                        return empty($data->end_date) ? "" : date('d/m/Y', strtotime($data->end_date));
                    },
                    'filter' => \yii\jui\DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'end_date',
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => ['class' => 'form-control']
                    ]),
                    'visible' => $contentcategory->has_end_date,
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
                    'template' =>(Yii::$app->session['type']==11)?'{view} {update} {activate} {deactivate}':'{view} {update} {delete} {activate} {deactivate}',
                    'visibleButtons' => [
                        'activate' => function ($model, $key, $index) {
                            $user = Yii::$app->session["currentUser"];
                            return (($model->status == 0) && ($user->checkAccess($user->type, "/content", "activate") == 1)) ? true : false;
                        },
                        'deactivate' => function ($model, $key, $index) {
                            $user = Yii::$app->session["currentUser"];
                            return (($model->status == 1) && ($user->checkAccess($user->type, "/content", "deactivate") == 1)) ? true : false;
                        },
                        'update' => function ($model, $key, $index) {
                            $user = Yii::$app->session["currentUser"];
                            return (($user->checkAccess($user->type, "/content", "update") == 0)) ? false : true;
                        },
                        'delete' => function ($model, $key, $index) {
                            $user = Yii::$app->session["currentUser"];
                            return (($user->checkAccess($user->type, "/content", "delete") == 0)) ? false : true;
                        },
                        'view' => function ($model, $key, $index) {
                            $user = Yii::$app->session["currentUser"];
                            return (($user->checkAccess($user->type, "/content", "view") == 0)) ? false : true;
                        }
                    ],
                    'buttons' => [
                        'deactivate' => function($url, $model) {
                            return Html::a(
                                    '<span class="glyphicon glyphicon-off"></span>', ['content/deactivate', 'id' => $model->id], [
                                    'class' => 'btn btn-danger btn-xs btn-marg', 'title' => Yii::t('app', 'Deactivate')
                                    ]
                            );
                        },
                            'activate' => function($url, $model) {
                            return Html::a(
                                    '<span class="glyphicon glyphicon-ok"></span>', ['content/activate', 'id' => $model->id], [
                                    'class' => 'btn btn-success btn-xs btn-marg', 'title' => Yii::t('app', 'Activate')
                                    ]
                            );
                        },
                            'view' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['content/view', 'id' => $model->id], [
                                    'title' => Yii ::t("app", "View"), 'data-pjax' => "0",
                                    'class' => 'btn btn-primary btn-xs btn-marg',
                            ]);
                        },
                            'update' => function ($url, $model) {
                            return Html::a(
                                    '<span class="glyphicon glyphicon-edit"></span>', ['content/update', 'id' => $model->id], [
                                    'title' => Yii::t("app", "Update"),
                                    'data-pjax' => "0",
                                    'class' => 'btn btn-success btn-xs btn-marg',
                                    ]
                            );
                        },
                            'delete' => function ($url, $model) {
                            return Html::a(
                                    '<span class="glyphicon glyphicon-remove"></span>', $url, ['title' => Yii::t("app", "Delete"),
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
            <?php Pjax::end(); ?>
</div>
<div style="clear:both;"></div>