<?php

namespace app\modules\api\models;

use app\models\Invoice as ModelsInvoice;
use app\modules\api\components\AppHelper as ApiHelper;
use app\models\InvoiceDetail;
use app\models\User;
use Exception;
use Yii;
use yii\db\Query;

class Invoice extends ModelsInvoice
{
    public function rules()
    {
        return [
            [['id', 'invoiceDetails', 'subject', 'payments', 'issue_date', 'due_date', 'detail_address', 'customer_name', 'user_id'], 'safe'],
            [['subtotal', 'tax', 'payments', 'amount_due'], 'integer'],
            [['subject'], 'string', 'max' => 50],
            [['status'], 'string', 'max' => 20],
        ];
    }

    public function fields()
    {
        return [
            'id',
            'user_id',
            'issue_date',
            'due_date',
            'subject',
            'subtotal',
            'tax',
            'payments',
            'amount_due',
            'customer_name',
            'detail_address',
            'status'
        ];
    }

    public function searchInvoice($id = null)
    {
        $mainQuery = (new Query)
            ->select([
                'invoice.id',
                'user.username',
                'user.address',
                'issue_date',
                'due_date',
                'subject',
                'subtotal',
                'tax',
                'payments',
                'amount_due',
                'customer_name',
                'detail_address',
                'invoice.status',
                'invoice.created_at'
            ])
            ->from(ModelsInvoice::tableName())
            ->leftJoin(User::tableName(), "invoice.user_id = user.id")
            ->where(['=', 'invoice.flag_active', '1']);
        if ($this->id) {
            $mainQuery->andWhere(['=', 'invoice.id', $this->id]);
        }

        $detailsQuery = (new Query)
            ->select([
                "*"
            ])
            ->from(InvoiceDetail::tableName())
            ->where(['=', 'invoice_detail.flag_active', '1']);

        $invoice = [];
        $i = 0;
        foreach ($mainQuery->all() as $data) {
            $invoice[$i]['ID'] = $data['id'];
            $invoice[$i]['Username'] = $data['username'];
            $invoice[$i]['Address'] = $data['address'];
            $invoice[$i]['Issue Date'] = $data['issue_date'];
            $invoice[$i]['Due Date'] = $data['due_date'];
            $invoice[$i]['Subject'] = $data['subject'];
            $invoice[$i]['Subtotal'] = $data['subtotal'];
            $invoice[$i]['Tax'] = $data['tax'];
            $invoice[$i]['Payments'] = $data['payments'];
            $invoice[$i]['Amount Due'] = $data['amount_due'];
            $invoice[$i]['Subtotal'] = $data['subtotal'];
            $invoice[$i]['Customer Name'] = $data['customer_name'];
            $invoice[$i]['Detail Address'] = $data['detail_address'];
            $invoice[$i]['Status'] = $data['status'];
            $invoice[$i]['Created At'] = $data['created_at'];
            $j = 0;
            foreach ($detailsQuery->all() as $details) {
                if ($data['id'] == $details['invoice_id']) {
                    $invoice[$i]['details'][$j] = [
                        'ID' => $details['id'],
                        'Item Type' => $details['item_type'],
                        'Description' => $details['description'],
                        'Quantity' => $details['quantity'],
                        'Unit Price' => $details['unit_price'],
                        'Amount' => $details['amount']
                    ];
                    $j++;
                }
            }
            $i++;
        }
        return $invoice;
    }

    public function deleteInvoice()
    {
        try {
            $invoice = self::find()->where(['id' => $this->id])->one();
            $invoice->flag_active = 0;
            if (!$invoice->save()) {
                throw new Exception();
            }
        } catch (Exception $ex) {
            return ApiHelper::apiError($ex->getCode(), $ex->getMessage());
        }
    }

    public function updateInvoice()
    {
    }
}
