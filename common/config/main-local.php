<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=mpt_pf_db',
            //'dsn' => 'mysql:host=localhost;dbname=gweb_db',
            'username' => 'root',
            'password' => 'Da123!@#',
           // 'password' => 'cbr@2018#',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'ecolaodimex@gmail.com',
                'password' => 'ecolao2016',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
    ],
];
