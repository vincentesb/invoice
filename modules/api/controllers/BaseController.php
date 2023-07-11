<?php

namespace app\modules\api\controllers;

use yii\rest\Controller;

class BaseController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
    }
}
