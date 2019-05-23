<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Content */

$this->title = Yii::t('app', 'Update') . " " . $contentcategory->title;
$this->params['breadcrumbs'][] = ['label' => $contentcategory->title, 'url' => ['index', 'type' => Yii::$app->session['type']]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="content-update">
    <?=
    $this->render('_form', [
        'model' => $model,
        'initialPreview' => $initialPreview,
        'initialPreviewConfig' => $initialPreviewConfig,
        'contentcategory' => $contentcategory
    ])
    ?>

</div>
