<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Expense;
use app\classes\Caption;

/**
 * ExpenseSearch represents the model behind the search form about `app\models\Expense`.
 */
class ExpenseSearch extends Expense {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'unit_id', 'expense_category_id', 'user_id', 'account_id'], 'integer'],
            [['cost', 'count_unit'], 'number'],
            [['description', 'date_oper'], 'safe'],
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
        $query = Expense::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['date_oper' => SORT_DESC]]
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
                'cost' => $this->cost,
                'unit_id' => $this->unit_id,
                'count_unit' => $this->count_unit,
                'expense_category_id' => ExpenseCategory::findChildID($this->expense_category_id),
                'date_oper' => $this->date_oper,
                'user_id' => $this->user_id,
                'account_id' => $this->account_id,
            ]);
        } else {
            $query->andFilterWhere([
                'id' => $this->id,
                'cost' => $this->cost,
                'unit_id' => $this->unit_id,
                'count_unit' => $this->count_unit,
                'expense_category_id' => ExpenseCategory::findChildID($this->expense_category_id),
                'date_oper' => $this->date_oper,
                'user_id' => Yii::$app->user->identity->id,
                'account_id' => $this->account_id,
            ]);
        }

        $query->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

}
