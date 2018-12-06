<?php

namespace app\models;

use Yii;
use app\classes\Caption;

/**
 * This is the model class for table "{{%unit}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $fullname
 *
 * @property Expense[] $expenses
 * @property Expensetemp[] $expensetemps
 */
class Unit extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%unit}}';
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
            [['name', 'fullname'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['fullname'], 'string', 'max' => 100],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'fullname' => 'Полное наименование',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpenses() {
        return $this->hasMany(Expense::className(), ['unit_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpensetemps() {
        return $this->hasMany(ExpenseTemplate::className(), ['unit_id' => 'id']);
    }

}
