<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@site' =>  "http://in-jazz-l/",
        '@cropp' => "http://in-jazz-l/upload/"
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'i18n' => Zelenin\yii\modules\I18n\Module::className(),
        'rbac' => [
            'class' => 'common\modules\rbac\RBAC',
        ],
        'permit' => [
            'class' => 'common\modules\rbac\RBAC',
            'params' => [
                'userClass' => 'common\models\User',
                'accessRoles' => ['admin'],
            ]
        ],
        'stat' => [
            'class' => 'common\modules\statistics\StatModule',
        ],
        'yii2images' => [
            'class' => 'rico\yii2images\Module',
            //be sure, that permissions ok
            //if you cant avoid permission errors you have to create "images" folder in web root manually and set 777 permissions
            'imagesStorePath' =>   '@frontend/web/upload/store', //path to origin images
            'imagesCachePath' => '@frontend/web/upload/cache', //path to resized copies
            'graphicsLibrary' => 'GD', //but really its better to use 'Imagick'
            'placeHolderPath' => realpath(dirname(__FILE__).'/../../../upload/no-image.jpg'), // if you want to get placeholder when image not exists, string will be processed by Yii::getAlias
            'imageCompressionQuality' => 100, // Optional. Default value is 85.
        ],
    ],
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
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'class' => Zelenin\yii\modules\I18n\components\I18N::className(),
            'languages' => ['uk-UK', 'ru-RU', 'en-EN'],
            'translations' => [
                'yii' => [
                    'class' => yii\i18n\DbMessageSource::className()
                ]
            ]
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
//        'image' => [
//            'class' => 'yii\image\ImageDriver',
//            'driver' => 'Imagick',  //GD or Imagick
//        ],
    ],
];
