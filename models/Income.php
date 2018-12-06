<?php

namespace app\models;

use Yii;
use app\classes\Caption;

/**
 * This is the model class for table "{{%income}}".
 *
 * @property integer $id
 * @property string $amount
 * @property integer $income_category_id
 * @property string $date_oper
 * @property integer $user_id
 * @property integer $account_id
 * @property integer $continue Продолжать ввод...
 *
 * @property User $user
 * @property IncomeCategory $incomeCategory
 * @property Account $account
 */
class Income extends \yii\db\ActiveRecord {

    public $continue = 0;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%income}}';
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
            [['amount', 'income_category_id', 'date_oper', 'user_id', 'account_id'], 'required'],
            [['amount'], 'number'],
            [['income_category_id', 'user_id', 'account_id'], 'integer'],
            [['date_oper'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'amount' => 'Сумма дохода',
            'income_category_id' => 'Категория доходов',
            'date_oper' => 'Дата операции',
            'user_id' => 'Пользователь',
            'account_id' => 'Счет (кошелек)',
            'continue' => 'Продолжать ввод...'
        ];
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
    public function getIncomeCategory() {
        return $this->hasOne(IncomeCategory::className(), ['id' => 'income_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount() {
        return $this->hasOne(Account::className(), ['id' => 'account_id']);
    }

    /**
     * Добавляем сумму на счет
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $account = Account::findOne($this->account_id);
            $account->current_sum = $account->current_sum + $this->amount;
            $account->update();
        }

        return parent::beforeSave($insert);
    }

    /**
     * Снимаем сумму со счета
     */
    public function beforeDelete() {
        if (parent::beforeDelete()) {

            $account = Account::findOne($this->account_id);
            $account->current_sum = $account->current_sum - $this->amount;
            $account->update();
            return true;
        } else {
            return false;
        }
    }

}
