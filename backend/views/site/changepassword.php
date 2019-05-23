<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = Yii::t('app', 'Change password');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-changepassword">
    <div class="user-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'current_password')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'new_password_repeat')->passwordInput(['maxlength' => true]) ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>

</div>
