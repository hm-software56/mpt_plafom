<?php

namespace backend\modules\event\models;

use Yii;
use \backend\modules\event\models\base\Invitation as BaseInvitation;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "invitation".
 */
class Invitation extends BaseInvitation
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
