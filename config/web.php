<?php

use kartik\datecontrol\Module;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'datecontrol' => [
            'class' => '\kartik\datecontrol\Module',
            'displaySettings' => [
                Module::FORMAT_DATE => 'dd-MM-yyyy',
                Module::FORMAT_TIME => 'hh:mm:ss a',
                Module::FORMAT_DATETIME => 'dd-MM-yyyy HH:mm',
            ],
            'saveSettings' => [
                Module::FORMAT_DATE => 'php:Y-m-d',
                Module::FORMAT_TIME => 'php:H:i:s',
                Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
            ],
            'autoWidgetSettings' => [
                Module::FORMAT_DATE => ['type' => 3, 'pluginOptions' => ['autoclose' => true]],
                Module::FORMAT_DATETIME => [], // setup if needed
                Module::FORMAT_TIME => [], // setup if needed
            ],
        ],
        'api' => [
            'basePath' => '@app/modules/api',
            'class' => 'app\modules\api\Module',
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            // 'enableCookieValidation' => false,

            // 'enableCsrfValidation' => false,

            'cookieValidationKey' => 'cb35a7e0af4463657a538492bab8c3effa70d7b1',
            // 'parsers' => [
            //     'application/json' => 'yii\web\JsonParser',
            // ]
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
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'sourcePath' => '@bower/admin-lte/dist',
                ],
            ],
        ],
        'pdf' => [
            'class' => 'kartik\mpdf\Pdf',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            'rules' => array(
                'site/assets/<key:\S+>' => 'site/assets',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            )
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
