<?php

namespace backend\models;

use Yii;
use \backend\models\base\HomeTranslate as BaseHomeTranslate;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "home_translate".
 */
class HomeTranslate extends BaseHomeTranslate
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
}
