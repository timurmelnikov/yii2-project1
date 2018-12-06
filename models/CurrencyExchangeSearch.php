<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CurrencyExchange;
use app\classes\Caption;

/**
 * CurrencyExchangeSearch represents the model behind the search form about `app\models\CurrencyExchange`.
 */
class CurrencyExchangeSearch extends CurrencyExchange {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'currency_id', 'number_units'], 'integer'],
            [['start_date',], 'safe'],
            [['official_exchange'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = CurrencyExchange::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['start_date'=>SORT_DESC]]
           

        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'start_date' => $this->start_date,
            'number_units' => $this->number_units,
            'official_exchange' => $this->official_exchange,
            'currency_id' => $this->currency_id,
        ]);




        return $dataProvider;
    }

}
