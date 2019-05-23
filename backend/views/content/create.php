<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Content */

$this->title = Yii::t('app', 'Create') . " " . $contentcategory->title;
$this->params['breadcrumbs'][] = ['label' => $contentcategory->title, 'url' => ['index', 'type' => Yii::$app->session['type']]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-create">
    <?=
    $this->render('_form', [
        'model' => $model,
        'initialPreview' => [],
        'initialPreviewConfig' => [],
        'contentcategory' => $contentcategory
    ])
    ?>

</div>
