<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ExpenseTemplate;
use app\classes\Caption;

/**
 * ExpenseTemplateSearch represents the model behind the search form about `app\models\ExpenseTemplate`.
 */
class ExpenseTemplateSearch extends ExpenseTemplate {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'unit_id', 'expense_category_id', 'user_id', 'account_id'], 'integer'],
            [['cost', 'count_unit'], 'number'],
            [['description', 'name'], 'safe'],
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
        $query = ExpenseTemplate::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
           $query->andFilterWhere([
                'id' => $this->id,
                'cost' => $this->cost,
                'unit_id' => $this->unit_id,
                'count_unit' => $this->count_unit,
                'expense_category_id' => $this->expense_category_id,
                'user_id' => Yii::$app->user->identity->id,
                'account_id' => $this->account_id,
            ]);
        $query->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

}
