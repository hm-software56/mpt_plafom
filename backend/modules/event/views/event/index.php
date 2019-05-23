<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\event\models\Event;
use backend\modules\event\models\Registration;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\event\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'ກອງ​ປະ​ຊ​ຸມ');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'ສ້າງ ກອງ​ປະ​ຊ​ຸມ'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary'=>'',
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],
           // 'event_title',
            [
                'attribute'=>'event_title',
                'label' =>Yii::t('app','ຊື່​ງານ (Event)'),
                'format'=>'raw',
                'value'=> function($model){
                    return $model->event_title;
                }
            ],
            [
                'label' =>Yii::t('app','ວັນ​ທີ (Date)'),
                'format'=>'raw',
                'value'=> function($model){
                    return $model->date_start;
                }
            ],
            [
                'label' => 'ມື້​ສຸດ​ທ້າຍ​ການ​ລົງ​ທະ​ບຽນ (Registration deadline)',
                'format'=>'raw',
                'value'=> function($model){
                    return Event::getdatetime($model->id,'deadline');
                           }
            ],
            [
                'label' =>Yii::t('app','Number registered'),
                'format'=>'raw',
                'value'=> function($model){
                    return Event::getcountregistered($model->id);
                }
            ],

            // 'date_end',
            // 'time_end',
            // 'location',
            // 'host',
            // 'created_by',
            

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                        'view' => function ($url, $model) {
                        return Html::a(
                                    '<span class="glyphicon glyphicon-eye-open"></span>', ['view', 'id' => $model->id], [
                                    'class' => 'btn btn-primary btn-xs btn-marg', 'title' => Yii::t('app', 'ເຊີນ​ຜູ້​ເຂົ້າ​ຮ່ວມ')
                                        ]
                                    );
                        },
                        'update' => function ($url, $model) {
                        return Html::a(
                                    '<span class="glyphicon glyphicon-edit"></span>', ['update', 'id' => $model->id], [
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
                                    'data-confirm' => Yii::t('app', 'ຖ້າ​ທ່ານ​ລືບ​ລາຍ​ການນີ້​ຂໍ້​ມູນ​ກ​່ຽວ​ກັບ​ລາຍ​ການນີ້​ຈະ​ຖືກ​ລືບ​ໄປ​ນຳ.'),
                                    'class' => 'btn btn-danger btn-xs btn-marg',
                                        ]
                        );
                    },
                        ],
                    //'contentOptions' => [ 'style' => 'width: 20px'],
                 ],
        ],
    ]); ?>
</div>
