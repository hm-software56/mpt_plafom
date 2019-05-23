<?php

namespace backend\models;

use Yii;
use \backend\models\base\SocialMedia as BaseSocialMedia;

/**
 * This is the model class for table "social_media".
 */
class SocialMedia extends BaseSocialMedia
{
    public $remove_photo;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'status' => Yii::t('app', 'Active?'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
        ];
        return array_merge(parent::rules(), $rules);
    }

}
