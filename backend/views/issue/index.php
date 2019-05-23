<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\IssueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Issues');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="issue-index">
    <div>
        <fieldset class="scheduler-border">
            <legend class="scheduler-border"><?= Yii::t("app", "Search Options") ?></legend>
            <div class="control-group">
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
        </fieldset>
    </div>

    <?php
    $user = Yii::$app->session["currentUser"];
    if ($user->checkAccess($user->type, "/issue", "create") == 1) {
        ?>
        <p align="right">
            <?= Html::a('<span class="fa fa-plus"></span> ' . Yii::t('app', 'Create Issue'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php } ?>
    <?php Pjax::begin(); ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'email:email',
            [
                'attribute' => 'issue_category_id',
                'format' => 'html',
                'value' => function ($data) {
                    return empty($data->issueCategory->title) ? "" : $data->issueCategory->title;
                },
                'filter' => Html::activeDropDownList($searchModel, 'issue_category_id', ArrayHelper::map(backend\models\IssueCategory::getList(), 'id', 'title'), ['class' => 'form-control', 'prompt' => '']),
            ],
            'subject',
            [
                'attribute' => 'created_date',
                'format' => 'html',
                'value' => function ($data) {
                    return empty($data->created_date) ? "" : date('d/m/Y H:i:s', strtotime($data->created_date));
                },
                'filter' => false,
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'visibleButtons' => [
                    'update' => function ($model, $key, $index) {
                        $user = Yii::$app->session["currentUser"];
                        return (($user->checkAccess($user->type, "/issue", "update") == 0)) ? false : true;
                    },
                    'delete' => function ($model, $key, $index) {
                        $user = Yii::$app->session["currentUser"];
                        return (($user->checkAccess($user->type, "/issue", "delete") == 0)) ? false : true;
                    },
                    'view' => function ($model, $key, $index) {
                        $user = Yii::$app->session["currentUser"];
                        return (($user->checkAccess($user->type, "/issue", "view") == 0)) ? false : true;
                    }
                ],
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', '#', [
                                'title' => Yii::t("app", "View"),
                                'onclick' => "$('#detail-modal').modal('show');
                                    $.ajax({
                                       type: 'GET',
                                       cache: false,
                                       url: '" . Yii::$app->urlManager->createUrl(['issue/view', 'id' => $model->id]) . "',
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
                                '<span class="glyphicon glyphicon-edit"></span>', ['issue/update', 'id' => $model->id], [
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

