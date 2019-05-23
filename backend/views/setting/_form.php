<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'has_photo')->checkbox() ?>

    <?= $form->field($model, 'has_video')->checkbox() ?>

    <?= $form->field($model, 'has_slide')->checkbox() ?>

    <?= $form->field($model, 'has_social_media')->checkbox() ?>

    <?= $form->field($model, 'has_menu_left')->checkbox() ?>

    <?= $form->field($model, 'has_menu_right')->checkbox() ?>

    <?= $form->field($model, 'has_menu_bottom')->checkbox() ?>

    <?= $form->field($model, 'has_menu_top')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
