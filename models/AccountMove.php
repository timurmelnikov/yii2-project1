<?php

namespace app\models;

use Yii;
use app\classes\Caption;
use app\models\Account;

/**
 * This is the model class for table "{{%account_move}}".
 *
 * @property integer $id
 * @property integer $account_from
 * @property integer $account_to
 * @property string $move_sum
 * @property string $date_oper
 * @property integer $user_id
 * @property string $description
 *
 * @property User $user
 * @property Account $accountFrom
 * @property Account $accountTo
 */
class AccountMove extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%account_move}}';
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
            [['account_from', 'account_to', 'move_sum', 'date_oper', 'user_id'], 'required'],
            [['account_from', 'account_to', 'user_id'], 'integer'],
            [['move_sum'], 'number'],
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
            'account_from' => 'Со счета',
            'account_to' => 'На счет',
            'move_sum' => 'Перемещ. сумма',
            'date_oper' => 'Дата операции',
            'user_id' => 'Пользователь',
            'description' => 'Описание',
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
    public function getAccountFrom() {
        return $this->hasOne(Account::className(), ['id' => 'account_from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountTo() {
        return $this->hasOne(Account::className(), ['id' => 'account_to']);
    }

    /**
     * Обновляем суммы на счетах...
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $account_from = Account::findOne($this->account_from);
            $account_from->current_sum = $account_from->current_sum - $this->move_sum;
            $account_from->update();

            $account_to = Account::findOne($this->account_to);
            $account_to->current_sum = $account_to->current_sum + $this->move_sum;
            $account_to->update();
        }

        return parent::beforeSave($insert);
    }

    /**
     *  "Откат", при удалении Перемещения
     */
    public function beforeDelete() {
        if (parent::beforeDelete()) {


            $account_from = Account::findOne($this->account_from);
            $account_from->current_sum = $account_from->current_sum + $this->move_sum;
            $account_from->update();

            $account_to = Account::findOne($this->account_to);
            $account_to->current_sum = $account_to->current_sum - $this->move_sum;
            $account_to->update();

            return true;
        } else {
            return false;
        }
    }

}
