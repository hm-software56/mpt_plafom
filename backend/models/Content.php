<?php

namespace backend\models;

use Yii;
use \backend\models\base\Content as BaseContent;
use backend\models\GallaryUploads;
use yii\helpers\Url;

/**
 * This is the model class for table "content".
 */
class Content extends BaseContent
{
    public $remove_photo;

    const UPLOAD_FOLDER = 'images/photolibrarys';

    public function rules()
    {
        $arr = [
            [['remove_photo'], 'integer'],
            [['ref'], 'safe'],
            [['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
            [['photo'], 'required', 'on' => 'create'],
        ];
        return array_merge(parent::rules(), $arr);
    }

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
                    'langForeignKey' => 'content_id',
                    'tableName' => "{{%content_translate}}",
                    'attributes' => [
                        'title', 'summary', 'details', 'keywords', 'meta_keywords', 'add_1', 'add_2', 'add_3', 'add_4', 'add_5'
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

        $models = Content::find()->localized()->all();
        foreach ($models as $model) {
            $list = array_merge($list, array(array('id' => $model->id, 'title' => $model->title, 'status' => 1)));
        }
        return $list;
    }
    public static function getListstatic()
    {
        $list = array();

        $models = Content::find()->localized()->where(['content_category_id'=>1])->all();
        foreach ($models as $model) {
            $list = array_merge($list, array(array('id' => $model->id, 'title' => $model->title, 'status' => 1)));
        }
        return $list;
    }


    public static function getUploadPath()
    {
        return Yii::getAlias('@webroot') . '/' . self::UPLOAD_FOLDER . '/';
    }

    public static function getUploadUrl()
    {
        return Url::base(true) . '/' . self::UPLOAD_FOLDER . '/';
    }

    public function getThumbnails($ref, $event_name)
    {
        $uploadFiles = GallaryUploads::find()->where(['ref' => $ref])->all();
        $preview = [];
        foreach ($uploadFiles as $file) {
            $preview[] = [
                'url' => self::getUploadUrl(true) . $ref . '/' . $file->real_filename,
                'src' => self::getUploadUrl(true) . $ref . '/thumbnail/' . $file->real_filename,
                'options' => ['title' => $event_name]
            ];
        }
        return $preview;
    }

    public function attributeLabels()
    {
        $array = [
            'status' => Yii::t('app', 'Active?'),
        ];
        return array_merge(parent::attributeLabels(), $array);
    }

}
