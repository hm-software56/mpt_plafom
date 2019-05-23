<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput() ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
    <?php
        $getuser=User::find()->where(['id'=>Yii::$app->user->id])->one();
        if (in_array($getuser->type, Yii::$app->params['type_user_register'])) {
            $label=Yii::t('app','Organization Name');
        }else{
            $label=Yii::t('app','Full Name');
        }
    ?>
    <?= $form->field($model, 'full_name')->textInput()->label($label) ?>

    <?= $form->field($model, 'type')->dropDownList(ArrayHelper::map(User::getAllRoles(), 'id', 'name'), ['prompt' => '- Choose Type -'])
    ?>

    <?= $form->field($model, 'status')->checkbox();
    ?>
    <?= $form->field($model, 'created_at')->hiddenInput(['value' => date('Y-m-d')])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
