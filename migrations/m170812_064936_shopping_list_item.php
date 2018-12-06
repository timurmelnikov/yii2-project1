<?php

use yii\db\Schema;
use yii\db\Migration;

class m170812_064936_shopping_list_item extends Migration
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
            '{{%shopping_list_item}}',
            [
                'id'=> $this->primaryKey(11),
                'shopping_list_id'=> $this->integer(11)->notNull()->comment('Список покупок'),
                'description'=> $this->string(200)->notNull()->comment('Описание'),
            ],$tableOptions
        );
        $this->createIndex('idx_shopping_list_id','{{%shopping_list_item}}',['shopping_list_id'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('idx_shopping_list_id', '{{%shopping_list_item}}');
        $this->dropTable('{{%shopping_list_item}}');
    }
}
