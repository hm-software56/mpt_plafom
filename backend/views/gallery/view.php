<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\GallaryUploads;

/* @var $this yii\web\View */
/* @var $model backend\models\Gallery */

$this->title = Yii::t('app', 'View Gallery');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-view">
    <?php $url = \Yii::$app->request->BaseUrl . '/images/' . Yii::$app->params['downloadFilePath'] . "/" . $model->photo; ?>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
                'attribute' => 'photo',
                'format' => 'raw',
                'value' => Html::img($url, ['title' => $model->title, 'class' => 'img-responsive img-fluid'])
            ],
            [
                'attribute' => 'detail',
                'format' => 'html',
                'value' => $model->detail,
            ],
            'sort',
            [
                'attribute' => 'date',
                'value' => isset($model->date) ? date('d/m/Y', strtotime($model->date)) : "",
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
        ],
    ])
    ?>

    <?php $dat = $model->getThumbnails($model->ref, $model->title); ?>
    <?php if (count($dat) > 0) { ?><br/><br/>
        <div class="panel panel-default">
            <div class="panel-body">
                <?= dosamigos\gallery\Gallery::widget(['items' => $model->getThumbnails($model->ref, $model->title)]); ?>
            </div>
        </div>
    <?php } ?>
    <br/>


</div>
