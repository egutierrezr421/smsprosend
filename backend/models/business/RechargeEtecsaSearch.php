<?php

namespace backend\models\business;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\business\RechargeEtecsa;

/**
 * RechargeEtecsaSearch represents the model behind the search form of `backend\models\business\RechargeEtecsa`.
 */
class RechargeEtecsaSearch extends RechargeEtecsa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'recharge_etecsa_type_id', 'user_id', 'customer_id', 'operator', 'quantity', 'type', 'status'], 'integer'],
            [['total_cost'], 'number'],
            [['email', 'phone', 'created_at', 'updated_at'], 'safe'],
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
        $query = RechargeEtecsa::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        // descomenta y utiliza tu relación con las traducciones para poder cargar los atributos de traducción
        // $query->leftJoin('table_lang',"table.id = table_lang.table_id AND table_lang.language='".Yii::$app->language."'");

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'recharge_etecsa_type_id' => $this->recharge_etecsa_type_id,
            'user_id' => $this->user_id,
            'customer_id' => $this->customer_id,
            'operator' => $this->operator,
            'quantity' => $this->quantity,
            'type' => $this->type,
            'total_cost' => $this->total_cost,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        /*
        //Ejemplo de configuración para utilización de DATERANGE
        if(isset($this->created_at) && !empty($this->created_at))
        {
            $date_explode = explode(' - ',$this->created_at);
            $start_date = GlobalFunctions::formatDateToSaveInDB($date_explode[0]).' 00:00:00';
            $end_date = GlobalFunctions::formatDateToSaveInDB($date_explode[1]).' 23:59:59';

            $query->andFilterWhere(['>=', 'created_at', $start_date])
                ->andFilterWhere(['<=', 'created_at', $end_date]);

            $this->created_at = null;
        }
        */

        return $dataProvider;
    }
}
