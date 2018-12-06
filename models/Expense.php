<?php

namespace app\models;

use Yii;
use app\classes\Caption;
use app\models\ExpenseCategory;
use app\models\Account;

/**
 * This is the model class for table "{{%expense}}".
 *
 * @property integer $id
 * @property string $cost
 * @property integer $unit_id
 * @property string $count_unit
 * @property integer $expense_category_id
 * @property string $description
 * @property string $date_oper
 * @property integer $user_id
 * @property integer $account_id
 *
 * @property ExpenseCategory $expenseCategory
 * @property User $user
 * @property Account $account
 * @property Unit $unit
 */
class Expense extends \yii\db\ActiveRecord {

    public $continue = 0;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%expense}}';
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
            [['cost', 'unit_id', 'count_unit', 'date_oper', 'user_id', 'account_id', 'expense_category_id'], 'required'],
            [['cost', 'count_unit'], 'number'],
            [['unit_id', 'expense_category_id', 'user_id', 'account_id'], 'integer'],
            [['cost'], 'checkSumAccount'],
            [['count_unit'], 'double', 'min' => 0.01],
            [['date_oper'], 'safe'],
            [['description'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cost' => 'Сумма расхода',
            'unit_id' => 'Единица измерения',
            'count_unit' => 'Количество',
            'expense_category_id' => 'Категория расходов',
            'description' => 'Описание',
            'date_oper' => 'Дата операции',
            'user_id' => 'Пользователь',
            'account_id' => 'Счет (кошелек)',
            'continue' => 'Продолжать ввод...'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpenseCategory() {
        return $this->hasOne(ExpenseCategory::className(), ['id' => 'expense_category_id']);
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
    public function getAccount() {
        return $this->hasOne(Account::className(), ['id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit() {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }

    /**
     * Снимаем сумму со счета
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {

            $account = Account::findOne($this->account_id);
            $account->current_sum = $account->current_sum - $this->cost;
            $account->update();
        }

        return parent::beforeSave($insert);
    }

    /**
     * Возвратщаем сумму на счет
     */
    public function beforeDelete() {
        if (parent::beforeDelete()) {

            $account = Account::findOne($this->account_id);
            $account->current_sum = $account->current_sum + $this->cost;
            $account->update();
            return true;
        } else {
            return false;
        }
    }

    //Валидаторы
    /**
     * Проверка достаточности суммы на счете
     */
    public function checkSumAccount($attribute, $params) {
        if ($this->isNewRecord) {
            $account = Account::findOne($this->account_id);
            if ($account->current_sum < $this->cost) {
                $this->addError($attribute, Caption::VALIDATION_EXPENSE_SUM_ACCOUNT);
            }
        }
    }

}
