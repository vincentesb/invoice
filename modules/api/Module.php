<?php

namespace app\modules\api;

use app\modules\api\components\ErrorResponseHelper;
use Yii;
use yii\console\Application;
use yii\web\Response;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\api\controllers';

    public function init()
    {
        parent::init();

        Yii::$app->setComponents(
            [
                'request' => [
                    'class' => 'yii\web\Request',
                    'enableCookieValidation' => false,
                    'enableCsrfValidation' => false,
                    'parsers' => [
                        'application/json' => 'yii\web\JsonParser'
                    ]
                ],
                'response' => [
                    'class' => 'yii\web\Response',
                    'format' => Response::FORMAT_JSON,
                    'on beforeSend' => [
                        ErrorResponseHelper::class,
                        'beforeResponseSend',
                    ]
                ],
                'formatter' => [
                    'class' => 'yii\i18n\Formatter',
                    'dateFormat' => 'php:Y-m-d',
                ],
            ]
        );

        if (!Yii::$app instanceof Application) {
        }
    }
}
