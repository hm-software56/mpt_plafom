<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SocialMedia */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Social Media'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="social-media-view">

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'photo',
                'value' => (\Yii::$app->request->BaseUrl . '/images/' . Yii::$app->params['downloadFilePath'] . "/" . $model->photo),
                'format' => ['image', ['width' => '30']],
            ],
            'icon',
            'link',
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

</div>
