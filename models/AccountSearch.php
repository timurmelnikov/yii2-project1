<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Account;
use app\classes\Caption;

/**
 * AccountSearch represents the model behind the search form about `app\models\Account`.
 */
class AccountSearch extends Account {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'state', 'user_id'], 'integer'],
            [['name', 'user_id'], 'safe'],
            [['current_sum'], 'number'],
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
        $query = Account::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
                'current_sum' => $this->current_sum,
                'state' => $this->state,
                'user_id' => $this->user_id,
            ]);
        } else {
            $query->andFilterWhere([
                'id' => $this->id,
                'current_sum' => $this->current_sum,
                'state' => $this->state,
                'user_id' => Yii::$app->user->identity->id,
            ]);
        }




        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

}
