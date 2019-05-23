<?php

namespace backend\models;

use Yii;
use \backend\models\base\Gallery as BaseGallery;
use backend\models\GallaryUploads;
use yii\helpers\Url;

/**
 * This is the model class for table "gallery".
 */
class Gallery extends BaseGallery
{
    public $remove_photo;

    const UPLOAD_FOLDER = 'images/photolibrarys';

    public function rules()
    {
        $arr = [
            [['remove_photo'], 'integer'],
            [['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
            [['photo'], 'required', 'on' => 'create'],
            [['ref'], 'safe'],
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
                    'langForeignKey' => 'gallery_id',
                    'tableName' => "{{%gallery_translate}}",
                    'attributes' => [
                        'title', 'detail'
                    ]
                ],
            ];
        } else {
            return [];
        }
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
