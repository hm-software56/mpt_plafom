<?php

namespace backend\models;

use Yii;
use \backend\models\base\TypeHomeTranslate as BaseTypeHomeTranslate;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "type_home_translate".
 */
class TypeHomeTranslate extends BaseTypeHomeTranslate
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
