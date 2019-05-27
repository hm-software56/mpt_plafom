<?php

$config = [
    'components' => [
        'request' => [
            'cookieValidationKey' => '2UHCHR4fTqHQidJhfTq-0xn4289E-McV',
        ],
        'language' => 'en',
    ],
    'name' => Yii::t('app', 'MPT'),
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    //$config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
