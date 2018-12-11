<?php

use yii\db\Migration;

/**
 * Class m181211_150629_create_table_unit
 */
class m181211_150629_create_table_unit extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%unit}}', [

            'id' => $this->primaryKey(11),
            'name' => $this->string(50)->notNull()->comment('Наименование'),
            'fullName' => $this->string(100)->notNull()->comment('Полное наименование'),
            'note' => $this->string(255)->notNull()->comment('Примечание'),
        ]);

        $this->addCommentOnTable('{{%unit}}', 'Единицы измерения');
        $this->batchInsert('{{%unit}}', ['name', 'fullName'], [
            ['опер', 'Операция'],
            ['г', 'Грамм'],
            ['м', 'Метр'],
            ['пач', 'Пачка'],
            ['шт', 'Штука'],
            ['м2', 'Метр квадратный'],
            ['кг', 'Килограмм'],
            ['проезд', 'Проезд'],
            ['бан', 'Банка']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181211_150629_create_table_unit cannot be reverted.\n";

        return false;
    }

}
