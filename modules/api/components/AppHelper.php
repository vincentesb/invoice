<?php

namespace app\modules\api\components;

use Yii;

class AppHelper
{
    public static function apiError($errorCode = 500, $errorMsg = 'Internal Server Error', $errorData = null, $success = null)
    {
        $errorCode = $errorCode <= 100 || $errorCode >= 600 ? 500 : $errorCode;
        $errorResponse = [
            'path' => Yii::$app->request->absoluteUrl,
            'success' => $success ?: false,
            'code' => $errorCode,
            'timestamp' => date('Y-m-d H:i:s'),
            'message' => $errorMsg
        ];
        if ($errorData != null) {
            $errorResponse['data'] = $errorData;
        }

        Yii::$app->response->statusCode = $errorCode;
        return $errorResponse;
    }
}
