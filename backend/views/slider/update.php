<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Slider */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Slider',
    ]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sliders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

?>
<div class="slider-update">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])

    ?>

</div>
