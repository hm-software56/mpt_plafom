<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SocialMedia */

$this->title = Yii::t('app', 'Update Box  Right');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Social Media'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

?>
<div class="social-media-update">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])

    ?>

</div>
