<?php

namespace backend\models;

use Yii;
use \backend\models\base\Slider as BaseSlider;

/**
 * This is the model class for table "slider".
 */
class Slider extends BaseSlider
{
    public $remove_photo;

    public function behaviors()
    {

        $langfortranslate = [];
        foreach (Yii::$app->params['languages'] as $language => $value) {
            if ($language != Yii::$app->params['defaultLang']) {
                $langfortranslate[$language] = $language;
            }
        }
        if (count(Yii::$app->params['languages']) > 1) {
            return [
                'ml' => [
                    'class' => \omgdef\multilingual\MultilingualBehavior::className(),
                    'languages' => $langfortranslate,
                    'defaultLanguage' => Yii::$app->params['defaultLang'],
                    'langForeignKey' => 'slider_id',
                    'tableName' => "{{%slider_translate}}",
                    'attributes' => [
                        'title', 'details'
                    ]
                ],
            ];
        } else {
            return [];
        }
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

    public static function find()
    {
        return new \omgdef\multilingual\MultilingualQuery(get_called_class());
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'status' => Yii::t('app', 'Active?'),
        ]);
    }

}
