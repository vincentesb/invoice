<?php

use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\InvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

if (Yii::$app->session->hasFlash('success')) {
    echo Alert::widget([
        'options' => [
            'class' => 'alert-success',
        ],
        'body' => Yii::$app->session->getFlash('success'),
    ]);
}

if (Yii::$app->session->hasFlash('error')) {
    echo Alert::widget([
        'options' => [
            'class' => 'alert-danger',
        ],
        'body' => Yii::$app->session->getFlash('error'),
    ]);
}

$this->title = 'Invoice';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="invoice-index">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6" style="padding-left: 20px;">
                <h1 class="m-0">Invoice</h1>
            </div>
            <div class="col-sm-6" style="padding: 0 20px 10px 20px;" align="right">
                <?= Html::a('Add Invoice', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <div class="row" style="padding: 0 20px;">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive" style="align-content:flex-end">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $model,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'issue_date',
                            'due_date',
                            'subject',
                            'subtotal',
                            'status',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{print} {view} {update} {delete}',
                                'buttons' => [
                                    'view' => function ($url) {
                                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => 'View']);
                                    },
                                    'update' => function ($url) {
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => 'Update']);
                                    },
                                    'print' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-print with-text"></span>', $url, ['title' => 'Print', 'id' => $model->id]);
                                    },
                                    'delete' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-trash with-text"></span>', $url, [
                                            'title' => 'Delete',
                                            'id' => $model->id,
                                            'data' => [
                                                'method' => 'post',
                                                'confirm' => 'Are you sure you want to delete this item?',
                                            ],
                                        ]);
                                    }
                                ],
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>