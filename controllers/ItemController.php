<?php

namespace app\controllers;

use Yii;
use app\models\Item;
use app\models\ItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionBrowse()
    {
        $model = new Item();
        $model->load(Yii::$app->request->queryParams);

        return $this->renderAjax(
            'browse',
            [
                'model' => $model
            ]
        );
    }

    /**
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param string $item_name
     * @param string $item_type
     * @param string $created_at
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $item_name, $item_type, $created_at)
    {
        if (($model = Item::findOne(['id' => $id, 'item_name' => $item_name, 'item_type' => $item_type, 'created_at' => $created_at])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
