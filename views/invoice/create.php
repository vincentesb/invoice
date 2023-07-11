<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Invoice */

$this->title = 'Add Invoice';
$this->params['breadcrumbs'][] = ['label' => 'Invoice', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-create" style="padding: 0 25px;">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
