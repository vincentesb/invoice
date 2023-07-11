<?php

use app\components\AppHelper;
use app\models\User;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-form">

    <?php $form = ActiveForm::begin(['id' => 'form-invoice']); ?>

    <h4>Invoice Detail</h4>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group field-invoiceID">
                <?= $form->field($model, 'id')
                    ->input(
                        'text',
                        [
                            'id' => 'id',
                            'value' => $model->id ?: "",
                            'placeholder' => "ID will generate after created",
                            'disabled' => true
                        ]
                    )
                ?>
                <div class="help-block"></div>
            </div>
            <?=
            $form->field($model, 'issue_date')
                ->widget(
                    DateControl::className(),
                    [
                        'id' => 'issueDate',
                        'widgetOptions' => [
                            'pluginOptions' => [
                                'issue_date' => AppHelper::convertDateTimeFormat(
                                    $model->issue_date,
                                    'Y-m-d',
                                    'd-m-Y'
                                )
                            ],
                        ],
                    ]
                )
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'subject')
                ->textInput([
                    'id' => 'subject',
                    'maxlength' => true,
                    'placeholder' => 'Enter your subject'
                ])
            ?>
            <?=
            $form->field($model, 'due_date')
                ->widget(
                    DateControl::className(),
                    [
                        'id' => 'dueDate',
                        'widgetOptions' => [
                            'pluginOptions' => [
                                'due_date' => AppHelper::convertDateTimeFormat(
                                    $model->due_date,
                                    'Y-m-d',
                                    'd-m-Y'
                                )
                            ],
                        ],
                    ]
                )
            ?>
        </div>
        <div class="col-md-4">
            <div class="container" style="width:70%;margin-right: 10px">
                <div class="card" style="margin-right: 0">
                    <div class="card-header">
                        <h4>Invoice Summary</h4>
                        <?php echo Yii::t('app', 'Total item (s)'); ?><span id="totalItem" style="float:right">0</span>
                        <br>
                        <?php echo Yii::t('app', 'Sub Total'); ?><span id="subtotal" style="float:right">0</span>
                        <br>
                        <?php echo Yii::t('app', 'Tax (10%)'); ?><span id="tax" style="float:right">0</span>
                        <br>
                        <?php echo Yii::t('app', 'Grand Total'); ?><span id="grandtotal" style="float:right">0</span>
                        <br>
                        <hr />
                        <?php if (!isset($isView)) { ?>
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                            <?= Html::button('Cancel', ['class' => 'btn btn-outline-danger']) ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <h4>Customer Info</h4>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($model, 'user_id')->widget(
                Select2::className(),
                [
                    'id' => 'userID',
                    'data' => ArrayHelper::map(
                        User::findActiveUser(),
                        'id',
                        'username'
                    ),
                    'options' => [
                        'placeholder' => 'Select Customer Name'
                    ],
                    'size' => Select2::MEDIUM,
                ]
            )
            ?>
        </div>
        <div class="col-md-4">
            <div class="form-group field-userAddress">
                <label class="control-label" for="userAddress">Detail Address</label>
                <textarea id="userAddress" class="form-control" value="" disabled="true">Please select customer name before</textarea>
                <div class="help-block"></div>
            </div>
        </div>
    </div>
    <div>
        <h4>Detail Items</h4>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="row" id="divProductDetail">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="table-responsive">
                            <table id="product-detail-table" class="table table-input" style="border-collapse: inherit;">
                                <thead>
                                    <tr>
                                        <th style="min-width: 15%; vertical-align:middle;">
                                            <?= Yii::t('app', 'Item') ?>
                                        </th>
                                        <th style="min-width: 10%; vertical-align:middle;">
                                            <?= Yii::t('app', 'Description') ?>
                                        </th>
                                        <th style="min-width: 10%; vertical-align:middle;">
                                            <?= Yii::t('app', 'Qty') ?>
                                        </th>
                                        <th style="min-width: 15%; vertical-align:middle;">
                                            <?= Yii::t('app', 'Unit Price') ?>
                                        </th>
                                        <th style="min-width: 10%; vertical-align:middle;">
                                            <?= Yii::t('app', 'Amount') ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="invoice_item"></tbody>
                            </table>
                            <?php if (!isset($isView)) : ?>
                                <?=
                                Html::a(
                                    "<i class='glyphicon glyphicon-plus with-text'></i>" . Yii::t(
                                        'app',
                                        'Add Item'
                                    ),
                                    '#',
                                    [
                                        'id' => 'btnAdd',
                                        'class' => 'btn btn-primary'
                                    ]
                                )
                                ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $form->field($model, 'subtotal')->hiddenInput(['id' => 'subtotalInput'])->label(false) ?>
    <?= $form->field($model, 'tax')->hiddenInput(['id' => 'taxInput'])->label(false) ?>
    <?= $form->field($model, 'amount_due')->hiddenInput(['id' => 'grandtotalInput'])->label(false) ?>
    <?php ActiveForm::end(); ?>
</div>

<?php
$viewMode = isset($isView) ? 1 : 0;

$address = Json::encode(ArrayHelper::map(User::findActiveUser(), 'id', 'address'));
$invoiceDetails = Json::encode($model->invoiceDetails);

$browseButtonColumn = '';
if (!isset($isView)) {
    $browseButtonColumn = Html::a('...', ['item/browse'], [
        'data-target-itemid' => '.itemID{{Count}}',
        'data-target-itemname' => '.itemName{{Count}}',
        'class' => 'btn btn-primary ModalDialogButton',
    ]);
}

$itemNameColumn = Html::textInput('item[{{Count}}][itemName]', '{{itemName}}', [
    'id' => 'itemName{{Count}}',
    'class' => 'form-control itemName itemName{{Count}}',
    'readonly' => true,
]);

$js = <<<JS
    $(document).ready(function () {
        $(document).ready(function () {
            var isView = $viewMode;
            if (isView) {
                disableForm('form-invoice');
                $('.btnDelete').hide();
            }
        });
        function disableForm(formId) {
            $('#' + formId + ' :input').prop('disabled', true);
        }
        var initValue = $invoiceDetails;

        $('#invoice-issue_date-disp').change(function () {
            validateDate();
        });
        $('#invoice-due_date-disp').change(function () {
            validateDate();
        });

        $('#invoice-user_id').change(function () {
            getAddress();
        });

        function getAddress() {
            $('#userAddress').val('');
            var userID = $('#invoice-user_id').val();
            var userAddress = "";
            Object.entries($address).forEach(entry => {
            const [key, value] = entry;
            if(key == userID) {
                userAddress = value;
            }
            });
            $('#userAddress').val(userAddress);
        }
        getAddress();

        function validateDate() {
            var issueDate = $('#invoice-issue_date-disp').val();
            var dueDate = $('#invoice-due_date-disp').val();

            if(issueDate && dueDate) {
                if(issueDate > dueDate) {
                    alert('Issue Date cannot be higher than dueDate');
                    $('#invoice-issue_date-disp').parent().parent().addClass('has-error');
                    return false;
                }
            }
        }

        $('#btnAdd').click(function() {
            addRow();
        });

        function addRow(item_type,description,quantity,unit_price,amount) {
            var count = $(".rowProduct").length;
            html = `
                <tr class="rowProduct" id="row[`+count+`]">
                    <td>
                        <input class="form-control" type="text" name="Invoice[invoiceDetails][`+count+`][item_type]" min="0" placeholder="Item Name" id="item`+count+`" value="` + (initValue[count] ? initValue[count].item_type : '') + `">
                    </td>
                    <td>
                        <input class="countSub form-control" type="text" name="Invoice[invoiceDetails][`+count+`][description]" min="0" placeholder="Description" id="description`+count+`" value="` + (initValue[count] ? initValue[count].description : '') + `">
                    </td>
                    <td>
                        <input class="countSub form-control" type="number" style="text-align:right" name="Invoice[invoiceDetails][`+count+`][quantity]" min="0" placeholder="0" id="quantity`+count+`" value="` + (initValue[count] ? initValue[count].quantity : '') + `">
                    </td>
                    <td>
                        <input class="countSub form-control" type="number" style="text-align:right;" name="Invoice[invoiceDetails][`+count+`][unit_price]" min="0" placeholder="0" id="unit_price`+count+`" value="` + (initValue[count] ? initValue[count].unit_price : '') + `">
                    </td>
                    <td>
                        <input class="form-control" type="number" style="text-align:right" name="Invoice[invoiceDetails][`+count+`][amount]" min="0" placeholder="0" id="amount`+count+`" value="` + (initValue[count] ? initValue[count].amount : '') + `" readonly>
                    </td>
                    <td><a type="button" data-row="[`+count+`]" class="btnDelete btn btn-block btn-danger"><i class='glyphicon glyphicon-trash'></i></a></td>
                </tr>`;
            $('#invoice_item').append(html);
            attachDeleteEvent();
            attachCountEvent();
            countSubtotal();
        }

        if (initValue.length > 0 && initValue != undefined) {
            initValue.forEach(function(entry) {
                addRow(entry.item_type.toString(), entry.description.toString(), entry.quantity.toString(), entry.unit_price.toString(), entry.amount.toString());
            });
        } else {
            addRow('', '', 0, 0, 0);
        }

        function attachDeleteEvent() {
            $('.btnDelete').off('click').on('click', function() {
                var rowId = $(this).data('row');
                deleteRow(rowId);
            });
        }

        function deleteRow(rowId) {
            var row = $('#row' + rowId);
            row.remove();
            countSubtotal();
        }
        attachDeleteEvent();

        function attachCountEvent() {
            $('.countSub').off('change').on('change', function() {
                countSubtotal();
            });
        }
        attachCountEvent();

        function countSubtotal() {
            var count = $(".rowProduct").length;
            var quantity=0;
            var quantityValue=0;
            var price = 0;
            var subtotal = 0;
            var amount = 0;
            var tax = 0;
            var grandTotal = 0;
            for(var i=0;i<count;i++) {
                quantityValue =  $(`#quantity`+i).val();
                price = $(`#unit_price`+i).val();
                amount = quantityValue*price;
                var amountForm = document.getElementById(`amount`+i);
                amountForm.value = amount;
                subtotal = subtotal + (quantityValue*price);
                quantity = (quantity*1 + quantityValue*1);
                tax = (subtotal*10/100);
                grandTotal = (subtotal+tax);
            }
            document.getElementById('totalItem').innerHTML = quantity;
            document.getElementById('subtotal').innerHTML = subtotal;
            document.getElementById('tax').innerHTML = tax;
            document.getElementById('grandtotal').innerHTML = grandTotal;
            document.getElementById('subtotalInput').value = subtotal;
            document.getElementById('taxInput').value = tax;
            document.getElementById('grandtotalInput').value = grandTotal;
        }
    });
JS;
$this->registerJs($js);
?>