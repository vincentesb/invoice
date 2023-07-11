<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\InvoiceDetail */

$this->title = Yii::t('app', 'Create Invoice Detail');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Invoice Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
