<?php
/* @var $this \yii\web\View */
/* @var $model \app\models\Invoice */

use app\components\AppHelper;

?>
<?php $this->context->layout = false; ?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>

<body>
    <div style="font-size: 12px">
        <div style="margin-top: 10px; text-align: center; font-size: 16px;"><b>Invoice</b></div>
        <div style="margin-top: 20px;">
            <div style="float: left; width: 65%; font-weight: bold;">
                <div style="display: block; margin-left: -3px;">
                    <table style="width: 100%; font-size: 12px;">
                        <tr>
                            <td style="width: 200px; font-weight: bold;"><?= $model->getAttributeLabel('id') ?></td>
                            <td style="width: 15px;">:</td>
                            <td><?= $model->id ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;"><?= $model->getAttributeLabel('issue_date') ?></td>
                            <td>:</td>
                            <td><?=
                                date_format(
                                    date_create($model->issue_date),
                                    'd/M/Y'
                                )
                                ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;"><?= $model->getAttributeLabel('due_date') ?></td>
                            <td>:</td>
                            <td><?=
                                date_format(
                                    date_create($model->due_date),
                                    'd/M/Y'
                                )
                                ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;"><?= $model->getAttributeLabel('subject') ?></td>
                            <td>:</td>
                            <td><?=
                                $model->subject
                                ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div style="margin-top: 30px;">
            <div style="display: block;">
                <table style="width: 100%; margin-left: -3px; font-size: 12px; border-collapse: collapse; ">
                    <thead>
                        <tr>
                            <th style="width: 5%; padding-bottom: 5px; text-align: center; border-bottom:1px solid #000;">No.</th>
                            <th style="width: 20%; padding-bottom: 5px; text-align: center; border-bottom:1px solid #000">Item Type</th>
                            <th style="width: 20%; padding-bottom: 5px; text-align: center; border-bottom:1px solid #000">Item Description</th>
                            <th style="width: 20%; padding-bottom: 5px; text-align: center; border-bottom:1px solid #000">Quantity</th>
                            <th style="width: 15%; padding-bottom: 5px; text-align: center; border-bottom:1px solid #000">Unit Price</th>
                            <th style="width: 10%; padding-bottom: 5px; text-align: center; border-bottom:1px solid #000">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($model->invoiceDetails as $detail) {
                        ?>
                            <tr style="margin: 5px 1%; ">
                                <td style="text-align: center; padding-top: 6px; padding-bottom: 6px; border-bottom:1px solid #000; "><?= $i ?></td>
                                <td style="padding-top: 6px; padding-bottom: 6px; border-bottom:1px solid #000; text-align: center"><?= $detail['item_type'] ?>&nbsp;</td>
                                <td style=" padding-top: 6px; padding-bottom: 6px; border-bottom:1px solid #000; text-align: center"><?= $detail['description'] ?></td>
                                <td style="padding-top: 6px; padding-bottom: 6px; border-bottom:1px solid #000; text-align: right"><?= $detail['quantity'] ?></td>
                                <td style="padding-top: 6px; padding-bottom: 6px; border-bottom:1px solid #000; text-align: right"><?= number_format($detail['unit_price'], 2, ",", ".") ?></td>
                                <td style="padding-top: 6px; padding-bottom: 6px; border-bottom:1px solid #000; text-align: right"><?= number_format($detail['amount'], 2, ",", ".") ?></td>
                            </tr>
                        <?php
                            $i = $i + 1;
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr style="margin: 5px 1%;">
                            <td colspan="5" style="text-align:right; border-top: 1px solid #000;">
                                <strong>
                                    <?=
                                    Yii::t('app', 'Subtotal :')
                                    ?>
                                </strong>
                                <br>
                                <strong>
                                    <?=
                                    Yii::t('app', 'Tax (10%) :')
                                    ?>
                                </strong>
                                <br>
                                <strong>
                                    <?=
                                    Yii::t('app', 'Payments :')
                                    ?>
                                </strong>
                                <br>
                                <strong>
                                    <?=
                                    Yii::t('app', 'Amount Due :')
                                    ?>
                                </strong>
                            </td>
                            <td style="text-align:right; border-top: 1px solid #000;">
                                <strong>
                                    <?=
                                    number_format($model->subtotal, 2, ",", ".")
                                    ?>
                                </strong>
                                <br>
                                <strong>
                                    <?=
                                    number_format($model->tax, 2, ",", ".")
                                    ?>
                                </strong>
                                <br>
                                <strong>
                                    <?=
                                    number_format($model->payments, 2, ",", ".")
                                    ?>
                                </strong>
                                <br>
                                <strong>
                                    <?=
                                    number_format($model->amount_due, 2, ",", ".")
                                    ?>
                                </strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <br>
        <br>
    </div>
</body>

</html>
<?php $this->endPage() ?>