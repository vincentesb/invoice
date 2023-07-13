<?php

namespace app\models;

use app\modules\api\components\AppHelper as ApiHelper;
use Exception;
use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property int $id
 * @property string $issue_date
 * @property string $due_date
 * @property string $subject
 * @property int $subtotal
 * @property int $tax
 * @property int $payments
 * @property int $amount_due
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Invoice extends \yii\db\ActiveRecord
{

    public $ID;
    public $item;
    public $Invoice;
    public $invoiceDetails;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['issue_date', 'due_date', 'subject', 'payments', 'user_id'], 'required'],
            [['invoiceDetails', 'subject', 'payments', 'issue_date', 'due_date', 'detail_address', 'customer_name'], 'safe'],
            [['subtotal', 'tax', 'payments', 'amount_due'], 'integer'],
            [['subject'], 'string', 'max' => 50],
            [['status'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Invoice ID',
            'user_id' => 'Customer Name',
            'issue_date' => 'Issue Date',
            'due_date' => 'Due Date',
            'subject' => 'Subject',
            'subtotal' => 'Subtotal',
            'tax' => 'Tax',
            'payments' => 'Payments',
            'amount_due' => 'Amount Due',
            'status' => 'Status',
        ];
    }

    public function fillInvoiceDetails()
    {
        $this->invoiceDetails = [];
        $invoiceDetailModel = InvoiceDetail::findAll(['invoice_id' => $this->id]);

        $i = 0;
        foreach ($invoiceDetailModel as $detail) {
            $this->invoiceDetails[$i]['id'] = $detail->id;
            $this->invoiceDetails[$i]['item_type'] = $detail->item_type;
            $this->invoiceDetails[$i]['description'] = $detail->description;
            $this->invoiceDetails[$i]['quantity'] = $detail->quantity;
            $this->invoiceDetails[$i]['unit_price'] = $detail->unit_price;
            $this->invoiceDetails[$i]['amount'] = $detail->amount;
            $i += 1;
        }
    }

    public function saveModel($data = null)
    {
        try {
            if ($data) {
                $this->issue_date = $data['issue_date'];
                $this->due_date = $data['due_date'];
                $this->subject = $data['subject'];
                $this->user_id = $data['user_id'];
                $this->payments = $data['payments'];
                $this->customer_name = $data['customer_name'];
                $this->detail_address = $data['detail_address'];

                $this->invoiceDetails = $data['invoiceDetails'];
                $oldDetails = InvoiceDetail::findAll(['invoice_id' => $this->id]);
                foreach ($oldDetails as $details) {
                    $details->delete();
                }
                $subtotal = 0;
                foreach ($data['invoiceDetails'] as $details) {
                    $detailModel = new InvoiceDetail();
                    $detailModel['invoice_id'] = $this->id;
                    $detailModel['item_type'] = $details['item_type'];
                    $detailModel['description'] = $details['description'];
                    $detailModel['quantity'] = $details['quantity'];
                    $detailModel['unit_price'] = $details['unit_price'];
                    $detailModel['amount'] = $details['quantity'] * $details['unit_price'];
                    $subtotal += $detailModel['amount'];
                    if (!$detailModel->save()) {
                        Yii::error($detailModel->getErrors());
                        throw new Exception();
                    }
                }

                $this->subtotal = $subtotal;
                $this->tax = $subtotal * 10 / 100;
                $this->amount_due = $data['subtotal'] - $data['payments'] + $data['tax'];
                if ($this->amount_due == 0) {
                    $this->status = 'PAID';
                } else {
                    $this->status = 'UNPAID';
                }

                if (!$this->save()) {
                    Yii::error($this->getErrors());
                    throw new Exception();
                }
            } else {
                $this->amount_due = $this->subtotal - $this->payments + $this->tax;
                if ($this->amount_due == 0) {
                    $this->status = 'PAID';
                } else {
                    $this->status = 'UNPAID';
                }

                if (!$this->save()) {
                    Yii::error($this->getErrors());
                    throw new Exception();
                }
                if ($this->invoiceDetails) {
                    $oldDetails = InvoiceDetail::findAll(['invoice_id' => $this->id]);
                    foreach ($oldDetails as $details) {
                        $details->delete();
                    }
                    foreach ($this->invoiceDetails as $detail) {
                        $detailModel = new InvoiceDetail();
                        $detailModel['invoice_id'] = $this->id;
                        $detailModel['item_type'] = $detail['item_type'];
                        $detailModel['description'] = $detail['description'];
                        $detailModel['quantity'] = $detail['quantity'];
                        $detailModel['unit_price'] = $detail['unit_price'];
                        $detailModel['amount'] = $detail['amount'];
                        if (!$detailModel->save()) {
                            Yii::error($detailModel->getErrors());
                            throw new Exception();
                        }
                    }
                } else {
                    $detailModel = [];
                    $allInvoiceDetail = InvoiceDetail::find(['invoice_id' => $this->id])->all();
                    foreach ($allInvoiceDetail as $detail) {
                        $detailModel = InvoiceDetail::find(['id' => $detail['id']])->one();
                        $detailModel['invoice_id'] = $this->id;
                        $detailModel['item_type'] = $detail['item_type'];
                        $detailModel['description'] = $detail['description'];
                        $detailModel['quantity'] = $detail['quantity'];
                        $detailModel['unit_price'] = $detail['unit_price'];
                        $detailModel['amount'] = $detail['amount'];
                        if (!$detailModel->save()) {
                            Yii::error($detailModel->getErrors());
                            throw new Exception();
                        }
                    }
                    $this->invoiceDetails = $allInvoiceDetail;
                }
            }
            $response = [
                "invoice" => $this,
                "details" => $this->invoiceDetails
            ];
            return ApiHelper::apiError(200, 'success', $response, 'success');
        } catch (Exception $ex) {
            Yii::error($ex);
            return ApiHelper::apiError($ex->getCode(), $ex->getMessage(), $this);
        }
    }
}
