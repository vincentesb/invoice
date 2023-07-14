<?php

namespace app\modules\api\controllers;

use app\modules\api\models\Invoice;
use app\modules\api\components\AppHelper as ApiHelper;
use Exception;
use Yii;

class InvoiceController extends \yii\rest\ActiveController
{

    public $modelClass = 'app\modules\api\models\Invoice';

    public function actionGetInvoice()
    {
        try {
            $model = new Invoice([
                'attributes' => Yii::$app->request->post()
            ]);

            if (!$model->validate()) {
                return [
                    'errors' => $model->errors
                ];
            }
            return $model->searchInvoice();
        } catch (Exception $ex) {
            return ApiHelper::apiError($ex->getCode(), $ex->getMessage());
        }
    }

    public function actionUpdateInvoice()
    {
        try {
            $data = Yii::$app->request->post();
            $model = Invoice::findOne($data['id']);
            $model->fillInvoiceDetails();
            if (!$model->validate()) {
                return [
                    'errors' => $model->errors
                ];
            }
            return $model->saveModel($data);
        } catch (Exception $ex) {
            return ApiHelper::apiError($ex->getCode(), $ex->getMessage());
        }
    }

    public function actionDeleteInvoice()
    {
        try {
            $model = new Invoice([
                'attributes' => Yii::$app->request->post()
            ]);

            return $model->deleteInvoice($model->id);
        } catch (Exception $ex) {
            return ApiHelper::apiError($ex->getCode(), $ex->getMessage());
        }
    }

    public function actionCreateInvoice()
    {
        try {
            $model = new Invoice([
                'attributes' => Yii::$app->request->post()
            ]);

            if (!$model->validate()) {
                return [
                    'errors' => $model->errors
                ];
            }
            return $model->saveModel();
        } catch (Exception $ex) {
            return ApiHelper::apiError($ex->getCode(), $ex->getMessage());
        }
    }
}
