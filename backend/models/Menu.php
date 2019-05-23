<?php

namespace backend\models;

use Yii;
use \backend\models\base\Menu as BaseMenu;

/**
 * This is the model class for table "menu".
 */
class Menu extends BaseMenu
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
                    'langForeignKey' => 'menu_id',
                    'tableName' => "{{%menu_translate}}",
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

    public static function showSubbutton($id)
    {
        $model = Menu::find()->where(['id' => $id])->one();
        if (Yii::$app->params["nbSubmenus"] == 1 && empty($model->menu_id)) {
            return TRUE;
        } else if (Yii::$app->params["nbSubmenus"] == 2 && empty($model->menu->menu_id)) {
            return TRUE;
        } else if (Yii::$app->params["nbSubmenus"] == 3 && empty($model->menu->menu->menu_id)) {
            return TRUE;
        } else if (Yii::$app->params["nbSubmenus"] == 4 && empty($model->menu->menu->menu->menu_id)) {
            return TRUE;
        } else if (Yii::$app->params["nbSubmenus"] == 5 && empty($model->menu->menu->menu->menu->menu_id)) {
            return TRUE;
        }
        return FALSE;
    }

    public static function getList($id = 0, $level = 0)
    {
        $list = array();
        $text_level = str_repeat("~ ~ ", $level);
        $condition = ($id == 0) ? 'menu_id is NULL' : 'menu_id=' . (int) $id;
        $models = Menu::find()->localized()->where($condition)->all();

        foreach ($models as $model) {
            $level = ($model->menu_id == NULL) ? 0 : $level;
            $list = array_merge($list, array(array('id' => $model->id, 'name' => $text_level . $model->name)));
            $childList = Menu::getList($model->id, ++$level);
            if (count($childList) > 0)
                $list = array_merge($list, $childList);
        }
        return $list;
    }

    public function attributeLabels()
    {
        $array = [
            'sort' => Yii::t('app', 'Sort Number'),
            'menu_id' => Yii::t('app', 'Parent'),
            'content_id' => Yii::t('app', 'Content'),
            'status' => Yii::t('app', 'Active?'),
        ];
        return array_merge(parent::attributeLabels(), $array);
    }

}
