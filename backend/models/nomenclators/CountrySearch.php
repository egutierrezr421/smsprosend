<?php

namespace backend\models\nomenclators;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\nomenclators\Country;

/**
 * CountrySearch represents the model behind the search form of `backend\models\nomenclators\Country`.
 */
class CountrySearch extends Country
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status','phone_code'], 'integer'],
            [['name','code', 'created_at', 'updated_at','sms_price'], 'safe'],
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
        $query = Country::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->leftJoin('country_lang','country.id = country_lang.country_id AND country_lang.language=\''.Yii::$app->language.'\'');

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'phone_code' => $this->phone_code,
            'sms_price' => $this->sms_price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'country_lang.name', $this->name])
        ;

        return $dataProvider;
    }
}
