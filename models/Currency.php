<?php

namespace app\models;

use Yii;
use app\classes\Caption;

/**
 * This is the model class for table "{{%currency}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $fullname
 * @property string $code
 *
 * @property CurrencyExchange[] $currencyExchanges
 */
class Currency extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%currency}}';
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
            [['name', 'fullname', 'code'], 'required'],
            [['name', 'code'], 'string', 'max' => 3],
            [['fullname'], 'string', 'max' => 100]
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
            'code' => 'Код',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencyExchanges() {
        return $this->hasMany(CurrencyExchange::className(), ['currency_id' => 'id']);
    }

}
