<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Slider */

$this->title = Yii::t('app', 'Create Slider');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sliders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="slider-create">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])

    ?>

</div>
