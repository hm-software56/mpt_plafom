<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace backend\models\base;

use Yii;

/**
 * This is the base-model class for table "home_translate".
 *
 * @property integer $id
 * @property string $name
 * @property string $language
 * @property integer $home_id
 *
 * @property \backend\models\Home $home
 * @property string $aliasModel
 */
abstract class HomeTranslate extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'home_translate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['home_id'], 'required'],
            [['home_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 45],
            [['home_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\models\Home::className(), 'targetAttribute' => ['home_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('models', 'ID'),
            'name' => Yii::t('models', 'Name'),
            'language' => Yii::t('models', 'Language'),
            'home_id' => Yii::t('models', 'Home ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHome()
    {
        return $this->hasOne(\backend\models\Home::className(), ['id' => 'home_id']);
    }




}
