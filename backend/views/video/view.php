<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Video */

$this->title = Yii::t('app', 'View Video');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Videos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-view">
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
                'attribute' => 'link',
                'format' => 'raw',
                'value' => '<iframe src="' . $model->link . '" width="100%" height="300" frameborder="0" allowfullscreen></iframe>'
            ],
            'sort',
            [
                'attribute' => 'status',
                'value' => $model->status == 0 ? Yii::t("app", "Inactive") : Yii::t("app", "Active"),
            ],
            [
                'attribute' => 'date',
                'value' => isset($model->date) ? date('d/m/Y', strtotime($model->date)) : "",
            ],
            [
                'attribute' => 'user_id',
                'value' => isset($model->user) ? $model->user->username : "",
            ],
        ],
    ])
    ?>

</div>
