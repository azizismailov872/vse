<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'profile' => [
            'class' => 'common\modules\profile\Module',
        ],
        'content' => [
            'class' => 'common\modules\content\Module',
        ],
        'auth' => [
            'class' => 'common\modules\auth\Module',
        ],
        'order' => [
            'class' => 'common\modules\order\Module',
        ],
        'message' => [
            'class' => 'common\modules\message\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'view' => [
            'theme' => [
                'pathMap' => ['@app/views' => '@app/themes/gentella/views'],
                'baseUrl' => '@web/themes/gentella/views',
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css',  
                    ],
                    'js' => [
                        
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js'=>[
                        'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js',
                        'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js',
                    ]
                ],
                'yii\web\JqueryAsset' => [
                    'js' => [
                        'https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js',
                    ],
                ],
            ],
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'login' => 'site/login',
                'logout' => 'site/logout',
                '/' => 'site/index',
                //Меню
                'menu' => 'content/menu/index',
                'menu/create' => 'content/menu/create',
                'menu/delete/<id:\d+>' => 'content/menu/delete',
                'menu/update/<id:\d+>' => 'content/menu/update',
                'menu/view/<id:\d+>' => 'content/menu/view',
                'menu/remove' => 'content/menu/delete-ajax',
                //Категории меню
                'menu-category' => 'content/menu-category/index',
                'menu-category/create' => 'content/menu-category/create',
                'menu-category/update/<id:\d+>' => 'content/menu-category/update',
                'menu-category/delete/<id:\d+>' => 'content/menu-category/delete',
                'menu-category/view/<id:\d+>' => 'content/menu-category/view',
                //Пользователи
                'users' => 'profile/backend-profile/index',
                'user/create' => 'profile/backend-profile/create',
                'user/update/<id:\d+>' => 'profile/backend-profile/update',
                'user/delete/<id:\d+>' => 'profile/backend-profile/delete',
                'user/view/<id:\d+>' => 'profile/backend-profile/view',
                'user/remove' => 'profile/backend-profile/delete-ajax',
                'user/delete-image' => 'profile/backend-profile/delete-image',
                'plus-balance' => 'profile/backend-profile/balance', 
                //Акция
                'stocks' => 'profile/stock/index',
                'stock/create' => 'profile/stock/create',
                'stock/delete' => 'profile/stock/delete',
                'stock/update/<id:\d+>' => 'profile/stocks/update',
                //Категории
                'categories' => 'order/category/index',
                'category/create' => 'order/category/create',
                'category/delete/<id:\d+>' => 'order/category/delete',
                'category/update/<id:\d+>' => 'order/category/update',
                'category/view/<id:\d+>' => 'order/category/view',
                'category/remove' => 'order/category/delete-ajax',
                'category/delete-image' => 'order/category/delete-image',
                //Заказ
                'orders' => 'order/backend-order/index',
                'order/create' => 'order/backend-order/create',
                'order/update/<id:\d+>' => 'order/backend-order/update',
                'order/delete/<id:\d+>' => 'order/backend-order/delete',
                'order/view/<id:\d+>' => 'order/backend-order/view',
                'order/remove' => 'order/backend-order/delete-ajax',
            ],
        ],
        
    ],
    'params' => $params,
];
