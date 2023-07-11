<?php

namespace app\components;

use Yii;
use yii\web\Controller;
use yii\web\UnauthorizedHttpException;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class ControllerUAC extends Controller {
    public function behaviors()
    {
        return [
                'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function init() {
        parent::init();
    }
}
