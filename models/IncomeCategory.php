<?php

namespace app\models;

use Yii;
use app\classes\Caption;
use yii\db\Query;

/**
 * This is the model class for table "{{%income_category}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property integer $account_id
 *
 * @property Income[] $incomes
 * @property Account $account
 * @property User $user
 */
class IncomeCategory extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%income_category}}';
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
            [['user_id', 'account_id', 'user_id'], 'integer'],
            [['name', 'account_id', 'user_id'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['name', 'user_id'], 'unique', 'targetAttribute' => ['name', 'user_id'], 'message' => Caption::VALIDATION_INCOME_CATEGORY_UNIQUE]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'name' => 'Наименование',
            'account_id' => 'Счет по умолчанию',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncomes() {
        return $this->hasMany(Income::className(), ['income_category_id' => 'id']);
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
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Возвращает список Пользователей и их Категорий
     */
    public static function findAllAndUserName() {
   
        if (Yii::$app->user->can('show_all')) {
 
            $rows = (new Query())
                ->select(['{{%income_category}}.id', 'CONCAT({{%income_category}}.name, " (", {{%user}}.username, ")") AS name'])
                ->from('{{%income_category}}')
                ->join('JOIN', '{{%user}}', '{{%user}}.id = {{%income_category}}.user_id')
                ->where([ ])
                ->orderBy('{{%user}}.username', '{{%income_category}}.name')
                ->all();

        } else {

            $rows = (new Query())
                ->select(['{{%income_category}}.id', '{{%income_category}}.name'])
                ->from('{{%income_category}}')
                ->join('JOIN', '{{%user}}', '{{%user}}.id = {{%income_category}}.user_id')
                ->where([ '{{%income_category}}.user_id' => Yii::$app->user->identity->id, ])
                ->orderBy('{{%user}}.username', '{{%income_category}}.name')
                ->all();          
        }

        return $rows;
    }

}
