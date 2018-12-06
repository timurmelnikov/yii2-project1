<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AccountMove;
use app\classes\Caption;

/**
 * AccountMoveSearch represents the model behind the search form about `app\models\AccountMove`.
 */
class AccountMoveSearch extends AccountMove {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'account_from', 'account_to', 'user_id'], 'integer'],
            [['move_sum'], 'number'],
            [['date_oper', 'description'], 'safe'],
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
        $query = AccountMove::find();

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
            'account_from' => $this->account_from,
            'account_to' => $this->account_to,
            'move_sum' => $this->move_sum,
            'date_oper' => $this->date_oper,
            'user_id' => $this->user_id,
        ]);
        } else {
        $query->andFilterWhere([
            'id' => $this->id,
            'account_from' => $this->account_from,
            'account_to' => $this->account_to,
            'move_sum' => $this->move_sum,
            'date_oper' => $this->date_oper,
            'user_id' => Yii::$app->user->identity->id,
        ]);
        }

        $query->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

}
