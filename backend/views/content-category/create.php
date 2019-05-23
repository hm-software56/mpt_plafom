<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ContentCategory */

$this->title = Yii::t('app', 'Create Content Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Content Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-category-create">

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
