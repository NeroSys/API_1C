<?php

use yii\db\Migration;

/**
 * Class m171207_155441_filter_product_bywith_tables
 */
class m171207_155441_filter_product_bywith_tables extends Migration
{
    public function safeUp()
    {

        $tableOptions = null;
        //Опции для mysql
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        //Создание таблицы для категорий
        $this->createTable('{{%product_buy_with_group}}', [
            'union_id' => $this->primaryKey(),
            'catalog_id' => $this->integer(11),
            'name' => $this->string(255)->notNull()->defaultValue('')
        ], $tableOptions);


        $this->createTable('{{%product_to_buy_with_group}}', [
            'union_id' => $this->integer()->notNull(),
            'art_id' => $this->integer()->notNull(),

        ], $tableOptions);

        $this->addPrimaryKey('pk-product_to_buy_with_group', '{{%product_to_buy_with_group}}', ['union_id', 'art_id']);

        //Создание индекса в таблице product_buy_with_group
        $this->createIndex('FK_product_buy_with_group-union', '{{%product_buy_with_group}}', 'union_id');
        $this->createIndex('FK_product_buy_with_group-catalog', '{{%product_buy_with_group}}', 'catalog_id');

        //Создание индекса в таблице product_to_buy_with_group
        $this->createIndex('fk-product_to_buy_with_group-union', '{{%product_to_buy_with_group}}', 'union_id');
        $this->createIndex('fk-product_to_buy_with_group-product', '{{%product_to_buy_with_group}}', 'art_id');

        $this->addForeignKey('fk-product_to_buy_with_group-product', '{{%product_to_buy_with_group}}', 'art_id', '{{%products}}', 'art_id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-product_to_buy_with_group-group', '{{%product_to_buy_with_group}}', 'union_id', '{{%product_buy_with_group}}', 'union_id', 'CASCADE', 'RESTRICT');

        $this->addForeignKey('fk-product_buy_with_group-catalog', '{{%product_buy_with_group}}', 'catalog_id', '{{%catalog_list}}', 'id', 'CASCADE', 'RESTRICT');

    }

    public function safeDown()
    {
        $this->dropTable('{{%product_buy_with_group}}');
        $this->dropTable('{{%product_to_buy_with_group}}');
    }
}

