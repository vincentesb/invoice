<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Invoice', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-view" style="padding: 0 25px;">
    <h1><?= Html::encode("Invoice #" . $this->title) ?></h1>
    <?=
    $this->render(
        '_form',
        ['model' => $model, 'isView' => true]
    )
    ?>
</div>