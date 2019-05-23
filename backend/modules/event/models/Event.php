<?php

namespace backend\modules\event\models;

use Yii;
use \backend\modules\event\models\base\Event as BaseEvent;
use yii\helpers\ArrayHelper;
use yii\web\Response;
/**
 * This is the model class for table "event".
 */
class Event extends BaseEvent
{

public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
             parent::rules(),
             [
                  # custom validation rules
             ]
        );
    }

    public static function getdatetime($id,$text)
    {
        $model=Event::find()->where(['id'=>$id])->one();
        if($text=="date_end")
        {
            return $model->date_end.' '.$model->time_end;
        }elseif($text=="deadline"){
            return '<span style="color:red">'.$model->register_deadline.'</span>';
        }else{
            return $model->date_start.' '.$model->time_start;
        }
        
                          
    }

    public static function getcountregistered($id)
    {
        $model=Registration::find()->joinWith(['invitation.event as events'])->where(['events.id'=>$id])->all();
      //  return count($model);
        return yii\helpers\Html::a(count($model), ['event/listregistered','id'=>$id]);
    }

}
