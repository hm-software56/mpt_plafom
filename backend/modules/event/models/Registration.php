<?php

namespace backend\modules\event\models;

use Yii;
use \backend\modules\event\models\base\Registration as BaseRegistration;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "registration".
 */
class Registration extends BaseRegistration
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
             
             [
                [['title','first_name', 'last_name', 'gender', 'position', 'org_name', 'telephone', 'invitation_id', 'code', 'date'], 'required','message'=>'{attribute} '.Yii::t('app','cannot be blank.').''],
             ],
             parent::rules()
        );
    }

    public function attributeLabels()
    {
        $array= [
            'title' => Yii::t('app', 'Title Persion'),
        ];
        return \array_merge(parent::attributeLabels(),$array);
    }
}
