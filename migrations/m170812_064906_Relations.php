<?php

use yii\db\Schema;
use yii\db\Migration;

class m170812_064906_Relations extends Migration
{

    public function init()
    {
       $this->db = 'db';
       parent::init();
    }

    public function safeUp()
    {
        $this->addForeignKey('fk_db1_shopping_list_user_from',
            '{{%shopping_list}}','user_from',
            '{{%user}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_db1_shopping_list_user_to',
            '{{%shopping_list}}','user_to',
            '{{%user}}','id',
            'CASCADE','CASCADE'
         );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_db1_shopping_list_user_from', '{{%shopping_list}}');
        $this->dropForeignKey('fk_db1_shopping_list_user_to', '{{%shopping_list}}');
    }
}
