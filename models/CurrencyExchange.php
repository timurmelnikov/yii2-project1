<?php

namespace app\models;

use Yii;
use app\classes\Caption;

/**
 * This is the model class for table "{{%currency_exchange}}".
 *
 * @property integer $id
 * @property string $start_date
 * @property integer $number_units
 * @property integer $currency_id
 * @property string $official_exchange
 */
class CurrencyExchange extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%currency_exchange}}';
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
            [['start_date', 'currency_id', 'number_units', 'official_exchange'], 'required'],
            [['start_date'], 'safe'],
            [['number_units', 'currency_id'], 'integer'],
            [['official_exchange'], 'number'],
            [['currency_id'], 'unique', 'targetAttribute' => ['currency_id', 'start_date'], 'message' => Caption::VALIDATION_CURRENCY_EXCHANGE_UNOQUE_DATE]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'start_date' => 'Дата начала',
            'currency_id' => 'Валюта',
            'number_units' => 'Количество единиц',
            'official_exchange' => 'Официальный курс',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency() {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

}
