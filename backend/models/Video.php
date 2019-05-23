<?php

namespace backend\models;

use Yii;
use \backend\models\base\Video as BaseVideo;

/**
 * This is the model class for table "video".
 */
class Video extends BaseVideo
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
                    'langForeignKey' => 'video_id',
                    'tableName' => "{{%video_translate}}",
                    'attributes' => [
                        'title',
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

    public function attributeLabels()
    {
        $array = [
            'status' => Yii::t('app', 'Active?'),
        ];
        return array_merge(parent::attributeLabels(), $array);
    }

}
