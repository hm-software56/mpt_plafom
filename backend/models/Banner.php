<?php

namespace backend\models;

use Yii;
use \backend\models\base\Banner as BaseBanner;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "banner".
 */
class Banner extends BaseBanner
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
