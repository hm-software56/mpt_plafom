<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        
        'i18n' => Zelenin\yii\modules\I18n\Module::className(),
        'rbac' => [
            'class' => 'yii2mod\rbac\Module',
            //Some controller property maybe need to change.
           /*'as access' => [
                'class' => yii2mod\rbac\filters\AccessControl::class
            ],*/ 
           'controllerMap' => [
                'assignment' => [
                    'class' => 'yii2mod\rbac\controllers\AssignmentController',
                    //'userClassName' => 'common\models\User',
                ]
            ]
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ]
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        // Rbac
        'i18n' => [
            'class' => Zelenin\yii\modules\I18n\components\I18N::className(),
            'languages' => ['la', 'en'],
            'translations' => [
                'app' => [
                    'class' => yii\i18n\DbMessageSource::className()
                ]
            ]
            
        ],
       /* 'i18n' => [
            'translations' => [
                'yii2mod.rbac' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/rbac/messages',
                ],
            // ...
            ],
        ],*/
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest', 'user'],
            //'cache' => 'yii\caching\FileCache',
            'itemTable' => 'authitem',
            'itemChildTable' => 'authitemchild',
            'assignmentTable' => 'authassignment',
            'ruleTable' => 'authrule',
        ],
    ],
];
