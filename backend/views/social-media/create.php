<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SocialMedia */

$this->title = Yii::t('app', 'Create Box  Right');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Box Right'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="social-media-create">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])

    ?>

</div>
