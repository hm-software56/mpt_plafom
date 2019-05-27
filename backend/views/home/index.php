<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Homes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="home-index">
    <p align="right">
        <?= Html::a(Yii::t('app', 'Add Home'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            [
                'attribute' => 'photo',
                'format' => 'raw',
                'value' => function($data) {
                    $url = \Yii::$app->request->BaseUrl . '/images/' . Yii::$app->params['downloadFilePath'] . '/' . $data->photo;
                    return Html::img($url, [ 'class' => 'img-responsive img-fluid','style'=>'width:150px;']);
                },
                    'filter' => false,
                ],
            'name',
            'like',
            [
                'attribute' => 'type_home_id',
                'value' => function($data) {
                    return $data->typeHome->name;
                },
                    'filter' => false,
                ],

                ['class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                        'update' => function ($url, $model) {
                        return Html::a(
                                '<span class="glyphicon glyphicon-edit"></span>',$url, [
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
        ]); ?>
</div>
