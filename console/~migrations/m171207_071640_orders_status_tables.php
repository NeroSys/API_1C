<?php

use yii\db\Migration;

/**
 * Class m171207_071640_orders_status_tables
 */
class m171207_071640_orders_status_tables extends Migration
{
    public function safeUp()
    {

        $tableOptions = null;
        //Опции для mysql
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        //Создание таблицы для категорий
        $this->createTable('{{%order_status_lang}}', [

            'status_id' => $this->integer(11),
            'lang_id' => $this->integer(11),
            'lang' => $this->string(50),
            'lang_name' => $this->string(255)->notNull()->defaultValue('')
        ], $tableOptions);

        //Создание таблиц категорий
        $this->createTable('{{%order_status_list}}', [
            'status_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('pk-order_status_list', '{{%order_status_list}}', ['status_id']);
        $this->addPrimaryKey('pk-order_status_lang', '{{%order_status_lang}}', ['status_id']);


        $this->createIndex('FK_order_status_lang', '{{%order_status_lang}}', 'status_id');
        $this->createIndex('FK_order_status_list', '{{%order_status_list}}', 'status_id');

        /* Связывание таблицы order_status_lang с таблицей order_status_list по первичным ключам.
        * При удалении записи в таблице order_status_list, записи из графы status_id таблицы order_status_lang будут удалены,
        * а при обновлении записи в таблице order_status_list, записи из графы status_id таблицы order_status_lang будут обновлены соответственно.
        */
        $this->addForeignKey(
            'FK_order_status_lang', '{{%order_status_lang}}', 'status_id', '{{%order_status_list}}', 'status_id', 'CASCADE', 'CASCADE'
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%order_status_lang}}');
        $this->dropTable('{{%order_status_list}}');
    }
}
