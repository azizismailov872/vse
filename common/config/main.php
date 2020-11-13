<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        [
            'class' => 'yii\filters\HttpCache',
            'lastModified' => function ($action, $params) {
                return time();
            },
            'sessionCacheLimiter' => 'public',
            'cacheControlHeader' => 'public, max-age=3600', // not needed since it is the default value
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;port=8889;dbname=martem3s_vse2',
            'username' => 'martem3s_vse2',
            'password' => 'Vsekginfo1234',
            'charset' => 'utf8',
            'enableSchemaCache' => true,
            // Продолжительность кеширования схемы.
            'schemaCacheDuration' => 3600,
            // Название компонента кеша, используемого для хранения информации о схеме
            'schemaCache' => 'cache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'htmlLayout' => 'layouts/main-html',
            'textLayout' => 'layouts/main-text',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.yandex.ru',
                'username' => 'Artbele@yandex.ru',
                'password' => 'Melis100694',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
        'formatter' => [
            'defaultTimeZone' => 'Asia/Bishkek',
            'locale' => 'ru-RU',
       ],
    ],
];
