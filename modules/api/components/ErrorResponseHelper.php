<?php

namespace app\modules\api\components;

use yii\base\Event;

class ErrorResponseHelper
{
    public static function beforeResponseSend(Event $event)
    {
        $response = $event->sender;
        $errorCode = $response->statusCode <= 100 || $response->statusCode >= 600 ? 500 : $response->statusCode;

        if ($errorCode != 200 && is_array($response->data)) {
            $response->data = AppHelper::apiError($errorCode, $response->data['message']);
            unset($response->data['type']);
            unset($response->data['line']);
            unset($response->data['stack-trace']);
            unset($response->data['file']);
            unset($response->data['name']);
        }
    }
}
