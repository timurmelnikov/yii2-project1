<?php

namespace app\models;

use app\classes\Caption;

/**
 * This is the model class for table "db1_auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 */
class AuthItem extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'db1_auth_item';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'type'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'name' => 'Наименование роли',
            'type' => 'Type',
            'description' => 'Описание роли',
            'rule_name' => 'Rule Name',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
//     public function getAuthAssignments() {
//         return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
//     }

    /**
     * @return \yii\db\ActiveQuery
     */
//     public function getRuleName() {
//         return $this->hasOne(AuthRule::className(), ['name' => 'rule_name']);
//     }

    /**
     * @return \yii\db\ActiveQuery
     */
//     public function getAuthItemChildren() {
//         return $this->hasMany(AuthItemChild::className(), ['parent' => 'name']);
//     }

    /**
     * @return \yii\db\ActiveQuery
     */
//     public function getAuthItemChildren0() {
//         return $this->hasMany(AuthItemChild::className(), ['child' => 'name']);
//     }

}
