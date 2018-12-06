<?php

namespace app\models;

use Yii;
use app\classes\Caption;

/**
 * This is the model class for table "{{%expense_template}}".
 *
 * @property integer $id
 * @property string $cost
 * @property integer $unit_id
 * @property string $count_unit
 * @property integer $expense_category_id
 * @property string $description
 * @property integer $user_id
 * @property integer $account_id
 * @property string $name
 *
 * @property ExpenseCategory $expenseCategory
 * @property User $user
 * @property Account $account
 * @property Unit $unit
 */
class ExpenseTemplate extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%expense_template}}';
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
            [['cost', 'unit_id', 'count_unit', 'expense_category_id', 'user_id', 'account_id', 'name'], 'required'],
            [['cost', 'count_unit'], 'number'],
            [['unit_id', 'expense_category_id', 'user_id', 'account_id'], 'integer'],
            [['description'], 'string', 'max' => 200],
            [['name'], 'string', 'max' => 50],
            [['user_id', 'name'], 'unique', 'targetAttribute' => ['user_id', 'name'], 'message' => Caption::VALIDATION_EXPENSE_TEMPLATE_UNIQUE_NAME],
            [['cost', 'expense_category_id', 'description', 'user_id', 'account_id'], 'unique', 'targetAttribute' => ['cost', 'expense_category_id', 'description', 'user_id', 'account_id'], 'message' => Caption::VALIDATION_EXPENSE_TEMPLATE_UNIQUE_OPERATION]
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
            'user_id' => 'Пользователь',
            'account_id' => 'Счет (кошелек)',
            'name' => 'Наименование шаблона',
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
     * формирование пунктов меню для команды "Создать из шаблона..."
     */
    public static function findDropdownItems() {
        $item = [];
        $models = Self::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
        foreach ($models as $model) {
            $item[] = ['label' => $model->name, 'url' => 'expense/create?tmp=' . $model->id];
        }
        return $item;
    }

}
