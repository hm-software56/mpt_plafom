<?php
namespace backend\models;

use Yii;
use \backend\models\base\ContentCategory as BaseContentCategory;

/**
 * This is the model class for table "content_category".
 */
class ContentCategory extends BaseContentCategory
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
                    'langForeignKey' => 'content_category_id',
                    'tableName' => "{{%content_category_translate}}",
                    'attributes' => [
                        'title', 'add_1', 'add_2'
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
            'has_add1' => Yii::$app->params['labelContentCategoryHasAdd1'],
            'has_add2' => Yii::$app->params['labelContentCategoryHasAdd2'],
            'has_add3' => Yii::$app->params['labelContentCategoryHasAdd3'],
            'has_add4' => Yii::$app->params['labelContentCategoryHasAdd4'],
            'has_add5' => Yii::$app->params['labelContentCategoryHasAdd5'],
        ];
        return array_merge(parent::attributeLabels(), $array);
    }
}
