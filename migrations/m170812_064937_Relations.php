<?php

use yii\db\Schema;
use yii\db\Migration;

class m170812_064937_Relations extends Migration
{

    public function init()
    {
       $this->db = 'db';
       parent::init();
    }

    public function safeUp()
    {
        $this->addForeignKey('fk_db1_shopping_list_item_shopping_list_id',
            '{{%shopping_list_item}}','shopping_list_id',
            '{{%shopping_list}}','id',
            'CASCADE','CASCADE'
         );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_db1_shopping_list_item_shopping_list_id', '{{%shopping_list_item}}');
    }
}
