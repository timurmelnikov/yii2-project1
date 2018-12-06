<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%shopping_list}}".
 *
 * @property integer $id
 * @property dste $date_list
 * @property string $name
 * @property integer $user_from
 * @property integer $user_to
 *
 * @property User $userFrom
 * @property User $userTo
 * @property ShoppingListItem[] $shoppingListItems
 */
class ShoppingList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shopping_list}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'user_from', 'user_to', 'date_list'], 'required'],
            [['user_from', 'user_to'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['user_from'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_from' => 'id']],
            [['user_to'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_to' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'date_list'=>'Дата листа',
            'user_from' => 'От пользователя',
            'user_to' => 'Пользователю',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFrom()
    {
        return $this->hasOne(User::className(), ['id' => 'user_from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTo()
    {
        return $this->hasOne(User::className(), ['id' => 'user_to']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShoppingListItems()
    {
        return $this->hasMany(ShoppingListItem::className(), ['shopping_list_id' => 'id']);
    }
}
