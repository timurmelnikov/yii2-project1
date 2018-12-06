<?php

namespace app\models;

use Yii;
use app\classes\Caption;
use yii\db\Query;

/**
 * This is the model class for table "{{%account}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $current_sum
 * @property integer $state
 * @property integer $user_id
 *
 * @property Expense[] $expenses
 * @property ExpenseTemplate[] $expenseTemplates
 * @property Income[] $incomes
 * @property IncomeCategory[] $incomeCategories
 * @property User $user
 * @property AccountMove[] $accountMoves
 * @property AccountMove[] $accountMoves0
 */
class Account extends \yii\db\ActiveRecord {

    const STATE_ACTIVE = 0;
    const STATE_CLOSE = 1;
    const SHOW_PERMISSION = 0;
    const SHOW_ALL = 1;
    const SHOW_USER = 2;
    
    

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%account}}';
    }

    public function behaviors() {
        return [

        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'state', 'user_id', 'current_sum'], 'required'],
            [['current_sum'], 'number'],
            [['state', 'user_id'], 'integer'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'current_sum' => 'Текущая сумма',
            'state' => 'Состояние',
            'user_id' => 'Пользователь',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpenses() {
        return $this->hasMany(Expense::className(), ['account_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpenseTemplates() {
        return $this->hasMany(ExpenseTemplate::className(), ['account_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncomes() {
        return $this->hasMany(Income::className(), ['account_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncomeCategories() {
        return $this->hasMany(IncomeCategory::className(), ['account_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountMoves() {
        return $this->hasMany(AccountMove::className(), ['account_from' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountMoves0() {
        return $this->hasMany(AccountMove::className(), ['account_to' => 'id']);
    }

    //Мои статические методы для списков

    /**
     * Возвращает список Пользователей и их Кошельков
     */
    public static function findAllAndUserName($show = Self::SHOW_PERMISSION) {
        if ($show == Self::SHOW_USER) {

            $rows = (new Query())
                ->select(['{{%account}}.id', '{{%account}}.name'])
                ->from('{{%account}}')
                ->join('JOIN', '{{%user}}', '{{%user}}.id = {{%account}}.user_id')
                ->where([
                    '{{%account}}.user_id' => Yii::$app->user->identity->id,
                    '{{%account}}.state' => 0
                    ])
                ->orderBy('{{%user}}.username', '{{%account}}.name')
                ->all();

        } else if ($show == Self::SHOW_ALL) {

            $rows = (new Query())
                ->select(['{{%account}}.id', 'CONCAT({{%account}}.name, " (", {{%user}}.username, ")") AS name'])
                ->from('{{%account}}')
                ->join('JOIN', '{{%user}}', '{{%user}}.id = {{%account}}.user_id')
                ->where([
                    '{{%account}}.state' => 0
                    ])
                ->orderBy('{{%user}}.username', '{{%account}}.name')
                ->all();

        } else
        if (Yii::$app->user->can('show_all')) {

            $rows = (new Query())
                ->select(['{{%account}}.id', 'CONCAT({{%account}}.name, " (", {{%user}}.username, ")") AS name'])
                ->from('{{%account}}')
                ->join('JOIN', '{{%user}}', '{{%user}}.id = {{%account}}.user_id')
                ->where([
                    '{{%account}}.state' => 0
                    ])
                ->orderBy('{{%user}}.username', '{{%account}}.name')
                ->all();


        } else {

            $rows = (new Query())
                ->select(['{{%account}}.id', '{{%account}}.name'])
                ->from('{{%account}}')
                ->join('JOIN', '{{%user}}', '{{%user}}.id = {{%account}}.user_id')
                ->where([
                    '{{%account}}.user_id' => Yii::$app->user->identity->id,
                    '{{%account}}.state' => 0
                    ])
                ->orderBy('{{%user}}.username', '{{%account}}.name')
                ->all();

        }

        return $rows;
    }

    /**
     * Возвращает  Кошельки пользователя и суммы в них
     */
    public static function findAllAndCurrentSum() {

            $rows = (new Query())
                ->select(['{{%account}}.id', 'CONCAT({{%account}}.name, " - ", {{%account}}.current_sum) AS name'])
                ->from('{{%account}}')
                ->where([
                    '{{%account}}.user_id' => Yii::$app->user->identity->id,
                    '{{%account}}.state' => 0
                    ])
                ->orderBy('{{%account}}.name')
                ->all();       

        return $rows;
    }


}
