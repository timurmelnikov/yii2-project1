<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%unit}}".
 *
 * @property int $id
 * @property string $name Наименование
 * @property string $fullName Полное наименование
 * @property string $note Примечание
 */
class Unit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%unit}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'fullName', 'note'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['fullName'], 'string', 'max' => 100],
            [['note'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'fullName' => 'Полное наименование',
            'note' => 'Примечание',
        ];
    }
}
