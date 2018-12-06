<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;
use app\classes\Caption;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'created_at', 'updated_at', 'state'], 'integer'],
            [['fullname', 'username', 'auth_key', 'email_confirm_token', 'password_hash', 'password_reset_token', 'email'], 'safe'],
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

//Управление "видимостьтью" пользователей для ролей
        //Если зашел пользователь с ролью "Администратор"
        if (Yii::$app->user->can('admin')) {
            //Если защел Суперпользователь
            if (Yii::$app->user->identity->username == 'root') {
                //Покажем всех и его тоже
                $query = User::find();
            } else {
                //Покажем всех, кроме Суперпользователя
                $query = User::find()->where(['<>', 'username', 'root']);
            }
            //Если защел Суперпользователь (конец)
        } else {
            $query = User::find()->where(['id' => Yii::$app->user->id]);
        }
//Управление "видимостьтью" пользователей для ролей (конец)

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'state' => $this->state,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'auth_key', $this->auth_key])
                ->andFilterWhere(['like', 'email_confirm_token', $this->email_confirm_token])
                ->andFilterWhere(['like', 'password_hash', $this->password_hash])
                ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'fullname', $this->fullname]);

        return $dataProvider;
    }

}
