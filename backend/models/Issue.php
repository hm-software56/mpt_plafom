<?php

namespace backend\models;

use Yii;
use \backend\models\base\Issue as BaseIssue;

/**
 * This is the model class for table "issue".
 */
class Issue extends BaseIssue
{
    public $remove_file;

    public function rules()
    {
        $rules = [
            [['remove_file'], 'integer'],
            [['email'], 'email'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, pdf, doc, docx'],
            [['issue_category_id', 'name'], 'required', 'on' => 'requiredCategory'],
        ];
        return array_merge(parent::rules(), $rules);
    }

    public function attributeLabels()
    {
        $array = [
            'issue_category_id' => Yii::t('app', 'Issue Category'),
        ];
        return array_merge(parent::attributeLabels(), $array);
    }

}
