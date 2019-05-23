<?php

namespace backend\modules\event;

/**
 * event module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\event\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->layout = '@backend/views/layouts/main_admin_register';
        parent::init();

        // custom initialization code goes here
    }
}
