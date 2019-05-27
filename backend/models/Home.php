<?php

namespace backend\models;

use Yii;
use \backend\models\base\Home as BaseHome;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "home".
 */
class Home extends BaseHome
{

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
                    'langForeignKey' => 'home_id',
                    'tableName' => "{{%home_translate}}",
                    'attributes' => [
                        'name'
                    ]
                ],
            ];
        } else {
            return [];
        }
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
