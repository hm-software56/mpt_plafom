<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "gallary_uploads".
 *
 * @property integer $upload_id
 * @property string $ref
 * @property string $file_name
 * @property string $real_filename
 */
class GallaryUploads extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallary_uploads';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ref'], 'string', 'max' => 100],
            [['file_name', 'real_filename'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'upload_id' => 'Upload ID',
            'ref' => 'Ref',
            'file_name' => 'File Name',
            'real_filename' => 'Real Filename',
        ];
    }
}
