<?php

namespace backend\models\business;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\business\Recharge;

/**
 * RechargeSearch represents the model behind the search form of `backend\models\business\Recharge`.
 */
class RechargeSearch extends Recharge
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'authorized_by', 'payment_method_id', 'paid', 'status'], 'integer'],
            [['amount', 'commission', 'total_to_pay'], 'number'],
            [['source_account', 'target_account', 'rejected_note', 'created_at', 'updated_at'], 'safe'],
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
        $query = Recharge::find();

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
            'user_id' => $this->user_id,
            'authorized_by' => $this->authorized_by,
            'payment_method_id' => $this->payment_method_id,
            'amount' => $this->amount,
            'commission' => $this->commission,
            'total_to_pay' => $this->total_to_pay,
            'paid' => $this->paid,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'source_account', $this->source_account])
            ->andFilterWhere(['like', 'target_account', $this->target_account])
            ->andFilterWhere(['like', 'rejected_note', $this->rejected_note]);

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
