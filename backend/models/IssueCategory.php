<?php

namespace backend\models;

use Yii;
use \backend\models\base\IssueCategory as BaseIssueCategory;

/**
 * This is the model class for table "issue_category".
 */
class IssueCategory extends BaseIssueCategory
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
                    'langForeignKey' => 'issue_category_id',
                    'tableName' => "{{%issue_category_translate}}",
                    'attributes' => [
                        'title'
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

    public static function getList()
    {
        $list = array();

        $models = IssueCategory::find()->localized()->all();
        foreach ($models as $model) {
            $list = array_merge($list, array(array('id' => $model->id, 'title' => $model->title, 'status' => 1)));
        }
        return $list;
    }

    public static function getActiveList()
    {
        $list = array();

        $models = IssueCategory::find(["status" => 1])->localized()->all();
        foreach ($models as $model) {
            $list = array_merge($list, array(array('id' => $model->id, 'title' => $model->title, 'status' => 1)));
        }
        return $list;
    }

}
