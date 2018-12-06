<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Income;
use app\classes\Caption;

/**
 * IncomeSearch represents the model behind the search form about `app\models\Income`.
 */
class IncomeSearch extends Income {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'income_category_id', 'user_id', 'account_id'], 'integer'],
            [['amount'], 'number'],
            [['date_oper'], 'safe'],
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
        $query = Income::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['date_oper'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (Yii::$app->user->can('show_all')) {
        $query->andFilterWhere([
            'id' => $this->id,
            'amount' => $this->amount,
            'income_category_id' => $this->income_category_id,
            'date_oper' => $this->date_oper,
            'user_id' => $this->user_id,
            'account_id' => $this->account_id,
        ]);
        } else {
        $query->andFilterWhere([
            'id' => $this->id,
            'amount' => $this->amount,
            'income_category_id' => $this->income_category_id,
            'date_oper' => $this->date_oper,
            'user_id' => Yii::$app->user->identity->id,
            'account_id' => $this->account_id,
        ]);
        }

        return $dataProvider;
    }

}
