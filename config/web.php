<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'es',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'rbac' => [
            'class' => 'yii2mod\rbac\Module',
        ],
    ],
    'components' => [
       'authManager' => [
            'class' => 'yii\rbac\DbManager', // Otra opción es 'yii\rbac\PhpManager
            'defaultRoles' => ['guest', 'user'],
         ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'c_72IRt49CqoKS2nvjxAnUzSAs5fQvgj',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'], //agrege info
                ],
            ],
        ],
        'security' => [
            'class' => 'yii\base\Security',
            'passwordHashStrategy' => 'password_hash', // Utiliza la estrategia de hash de contraseñas recomendada
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:d/m/Y', // Formato de fecha (día/mes/año)
            'timeFormat' => 'php:H:i:s', // Formato de hora (hora:minuto:segundo)
            'datetimeFormat' => 'php:d/m/Y H:i:s', // Formato de fecha y hora
            'timeZone' => 'America/Guayaquil', // Zona horaria de Ecuador
        ],
        'assetManager' => [
            'bundles' => [
                'yii\jui\DatePickerAsset' => [
                    'sourcePath' => null,
                    'basePath' => '@webroot/assets',
                    'baseUrl' => '@web/assets',
                    'js' => ['jquery-ui.min.js'], // Verifica si este archivo existe
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                //'registro' => 'site/registro',
                'prestamo/prestarlibro/<id:\d+>' => 'prestamo/prestarlibro',
                'prestamo/prestarpc/<id:\d+>' => 'prestamo/pretarpc',
            ],
        ],
        'i18n' => [
            'translations' => [
                'yii2mod.rbac' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages/',
                ],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';

    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
