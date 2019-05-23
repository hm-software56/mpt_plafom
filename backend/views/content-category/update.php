<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ContentCategory */

$this->title = Yii::t('app', 'Update Content Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Content Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="content-category-update">

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
