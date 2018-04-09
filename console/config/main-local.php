<?php
return [
    'components' => [
        //DB сайта
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=injazzmaster',
            'username' => 'root',
            'password' => 'qweasdzxc',
            'charset' => 'utf8',
            'enableSchemaCache' => false
        ],
        //Транзитная БД
        'db2' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=sproduccion.com;dbname=injazz',
            'username' => 'u_injazzj',
            'password' => 'Qp8hs2DX4qo3',
            'charset' => 'utf8',
            'enableSchemaCache' => false
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'htmlLayout' => 'layouts/main-html',
            'textLayout' => 'layouts/main-text',
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => ['funixan@gmail.com' => 'Guliver-PA'],
            ],
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'funixan@gmail.com',
                'password' => '85g5R2gwm8sGt7NN2FYqR',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
    ],
];
