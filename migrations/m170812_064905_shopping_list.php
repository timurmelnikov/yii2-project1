<?php

use yii\db\Schema;
use yii\db\Migration;

class m170812_064905_shopping_list extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%shopping_list}}',
            [
                'id'=> $this->primaryKey(11),
                'name'=> $this->string(50)->notNull()->comment('Наименование'),
                'user_from'=> $this->integer(11)->notNull()->comment('От пользователя'),
                'user_to'=> $this->integer(11)->notNull()->comment('Пользователю'),
            ],$tableOptions
        );
        $this->createIndex('idx_user_from','{{%shopping_list}}',['user_from'],false);
        $this->createIndex('idx_user_to','{{%shopping_list}}',['user_to'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('idx_user_from', '{{%shopping_list}}');
        $this->dropIndex('idx_user_to', '{{%shopping_list}}');
        $this->dropTable('{{%shopping_list}}');
    }
}
