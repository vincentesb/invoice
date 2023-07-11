<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InvoiceDetail;

/**
 * InvoiceDetailSearch represents the model behind the search form of `app\models\InvoiceDetail`.
 */
class InvoiceDetailSearch extends InvoiceDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'invoice_id', 'quantity', 'unit_price', 'amount'], 'integer'],
            [['item_type', 'description', 'customer_name', 'detail_address', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = InvoiceDetail::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'invoice_id' => $this->invoice_id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ]);

        $query->andFilterWhere(['like', 'item_type', $this->item_type])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'detail_address', $this->detail_address]);

        return $dataProvider;
    }
}
