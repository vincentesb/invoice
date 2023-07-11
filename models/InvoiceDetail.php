<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%invoice_detail}}".
 *
 * @property int $id
 * @property int $invoice_id
 * @property string $item_type
 * @property string $description
 * @property int $quantity
 * @property int $unit_price
 * @property int $amount
 * @property string $customer_name
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class InvoiceDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_id'], 'required'],
            [['invoice_id', 'quantity', 'unit_price', 'amount'], 'integer'],
            [['item_type', 'description', 'quantity', 'unit_price', 'amount'], 'safe'],
            [['item_type'], 'string', 'max' => 20],
            [['description'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'invoice_id' => Yii::t('app', 'Invoice ID'),
            'item_type' => Yii::t('app', 'Item Type'),
            'description' => Yii::t('app', 'Description'),
            'quantity' => Yii::t('app', 'Quantity'),
            'unit_price' => Yii::t('app', 'Unit Price'),
            'amount' => Yii::t('app', 'Amount'),
        ];
    }
}
