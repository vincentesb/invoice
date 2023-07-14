<?php

namespace app\controllers;

use Yii;
use app\models\Invoice;
use app\models\InvoiceSearch;
use Exception;
use kartik\widgets\ActiveForm;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
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

    /**
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new InvoiceSearch();
        $dataProvider = $model->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invoice model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->fillInvoiceDetails();

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Invoice();
        $model->issue_date = "";
        $model->subject = "";
        $model->due_date = "";
        $model->user_id = "";
        $model->subtotal = 0;
        $model->tax = 0;
        $model->payments = 0;
        $model->amount_due = 0;
        $model->detail_address = 0;
        $model->invoiceDetails = [];

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (!$model->saveModel()) {
                Yii::$app->session->setFlash(
                    'error',
                    Yii::t('app', 'Failed to save Invoice, please try again')
                );
                return $this->redirect(['index']);
            }
            Yii::$app->session->setFlash(
                'success',
                Yii::t('app', 'Successfully saved Invoice')
            );
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->fillInvoiceDetails();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (!$model->saveModel()) {
                Yii::$app->session->setFlash(
                    'error',
                    Yii::t('app', 'Failed to update Invoice, please try again')
                );
                return $this->redirect(['index']);
            }
            Yii::$app->session->setFlash(
                'success',
                Yii::t('app', 'Successfully updated Invoice')
            );
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Invoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->flag_active = 0;

        if (!$model->save()) {
            Yii::$app->session->setFlash(
                'error',
                Yii::t('app', 'Failed to delete Invoice, please try again')
            );
            throw new Exception();
        }

        Yii::$app->session->setFlash(
            'success',
            Yii::t('app', 'Successfully deleted Invoice')
        );

        return $this->redirect(['index']);
    }

    public function actionPrint($id)
    {
        $model = $this->findModel($id);
        $model->fillInvoiceDetails();

        $content = $this->render('print', [
            'model' => $model
        ]);

        $printFooter = 'Invoice';

        $pdf = Yii::$app->pdf;
        $pdf->content = $content;
        $pdf->methods = [
            'SetFooter' => [$printFooter],
        ];

        return $pdf->render('print', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
