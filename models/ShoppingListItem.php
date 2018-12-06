<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%shopping_list_item}}".
 *
 * @property integer $id
 * @property integer $shopping_list_id
 * @property string $description
 *
 * @property ShoppingList $shoppingList
 */
class ShoppingListItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shopping_list_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shopping_list_id', 'description'], 'required'],
            [['shopping_list_id'], 'integer'],
            [['description'], 'string', 'max' => 200],
            [['shopping_list_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShoppingList::className(), 'targetAttribute' => ['shopping_list_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shopping_list_id' => 'Список покупок',
            'description' => 'Описание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShoppingList()
    {
        return $this->hasOne(ShoppingList::className(), ['id' => 'shopping_list_id']);
    }
}
