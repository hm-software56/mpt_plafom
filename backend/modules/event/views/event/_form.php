<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
use kartik\time\TimePicker;
use kartik\datetime\DateTimePicker;
/* @var $this yii\web\View */
/* @var $model backend\modules\event\models\Event */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-form">

    <?php $form = ActiveForm::begin(['options'=>['autocomplete'=>'off']]);?>

    <?=$form->field($model, 'event_title')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'agenda')->textarea(['rows' => 6])?>

    <?=
    $form->field($model, 'date_start')->widget(\yii\jui\DatePicker::classname(), [
        'dateFormat' => 'yyyy-MM-dd',
        'clientOptions' => [
            'changeMonth' => true,
            'changeYear' => true,
            'autoSize' => true,
        ],
        'options' => ['class' => 'form-control', 'id' => 'date_start'],
    ])
    ?>
    <?=$form->field($model, 'time_start')->widget(TimePicker::classname(), []);?>

    <?=
    $form->field($model, 'date_end')->widget(\yii\jui\DatePicker::classname(), [
        'dateFormat' => 'yyyy-MM-dd',
        'clientOptions' => [
            'changeMonth' => true,
            'changeYear' => true,
            'autoSize' => true,
        ],
        'options' => ['class' => 'form-control', 'id' => 'date_end'],
    ])
    ?>

    <?=$form->field($model, 'time_end')->widget(TimePicker::classname(), []);?>

    <?=$form->field($model, 'location')->textInput(['maxlength' => true])?>
    
    <?=$form->field($model, 'map')->textInput(['maxlength' => true])?>
    <?=$form->field($model, 'host')->textInput(['maxlength' => true])?>
    <?=$form->field($model, 'contract')->textarea(['rows' => 4])->label("ລາຍ​ລະ​ອຽດ​ຜູ້​ປະ​ສານ​ງານ")?>
    
    <?=
    $form->field($model, 'register_deadline')->widget(\yii\jui\DatePicker::classname(), [
        'dateFormat' => 'yyyy-MM-dd',
        'clientOptions' => [
            'changeMonth' => true,
            'changeYear' => true,
            'autoSize' => true,
        ],
        'options' => ['class' => 'form-control', 'id' => 'register_deadline'],
    ])
    ?>
    <?=$form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false)?>
    <div class="form-group">
        <?=Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
