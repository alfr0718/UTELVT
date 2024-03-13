<?php

use app\models\User;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'es',
    'timeZone' => 'America/Guayaquil',
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
            //'defaultRoles' => ['guest', 'user'],
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
            'on afterLogin' => function ($event) {
                $user = $event->identity;
                $auth = Yii::$app->authManager;

                if ($user) { // Verificar si el usuario está autenticado correctamente
                    if ($user->tipo_usuario == User::TYPE_ADMIN) {
                        $role = $auth->getRole('admin');
                    } elseif ($user->tipo_usuario ==User::TYPE_DOCENTE) {
                        $role = $auth->getRole('docente');
                    } elseif ($user->tipo_usuario == User::TYPE_ESTUDIANTE) {
                        $role = $auth->getRole('estudiante');
                    } elseif ($user->tipo_usuario == User::TYPE_PERSONALB || $user->tipo_usuario == User::TYPE_GERENTE) {
                        $role = $auth->getRole('personal');
                    } else {
                        $role = $auth->getRole('usuario');
                    }

                    if ($role) { // Verificar si se obtuvo el rol correctamente
                        // Verificar si el usuario ya tiene el rol asignado
                        if (!$auth->checkAccess($user->id, $role->name)) {
                            // Quitar cualquier rol anterior y asignar el nuevo rol
                            $auth->revokeAll($user->id);
                            $auth->assign($role, $user->id);
                        }
                    } else {
                        Yii::warning("Rol no encontrado para el tipo de usuario: {$user->tipo_usuario}");
                    }
                } else {
                    Yii::warning("No se pudo obtener el usuario después de iniciar sesión.");
                }
            },

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
            'dateFormat' => 'php:d/m/Y',
            'timeFormat' => 'php:H:i:s',
            'datetimeFormat' => 'php:d/m/Y H:i:s',
            'timeZone' => 'America/Guayaquil',
            'defaultTimeZone' => 'America/Guayaquil',
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                //'registro' => 'site/registro',
                'user/change-password' => 'user/change-password',
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
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/adminlte/views'
                ],
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap4\BootstrapAsset' => [
                    'sourcePath' => null,
                    'css' => [],
                ],
            ],
        ],

    ],

    'as access' => [
        'class' => yii2mod\rbac\filters\AccessControl::class,
        'allowActions' => [
            'site/login',
            'site/logout',
            'site/signup',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
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
        'generators' => [ // here
            'crud' => [ // generator name
                'class' => 'yii\gii\generators\crud\Generator', // generator class
                'templates' => [ // setting for our templates
                    'yii2-adminlte3' => '@vendor/hail812/yii2-adminlte3/src/gii/generators/crud/default' // template name => path to template
                ]
            ]
        ]
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
