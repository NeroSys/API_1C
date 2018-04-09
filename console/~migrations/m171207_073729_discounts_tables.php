<?php

use yii\db\Migration;

/**
 * Class m171207_073729_discounts_tables
 */
class m171207_073729_discounts_tables extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_to_discount}}', [
            'discount_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),

        ], $tableOptions);

        $this->createTable('{{%brand_to_discount}}', [
            'discount_id' => $this->integer()->notNull(),
            'brand_id' => $this->integer()->notNull(),

        ], $tableOptions);


        $this->addPrimaryKey('pk-product_to_discount', '{{%product_to_discount}}', ['discount_id', 'product_id']);
        $this->addPrimaryKey('pk-brand_to_discount', '{{%brand_to_discount}}', ['discount_id', 'brand_id']);

        $this->createIndex('idx-brand_to_discount-discount_id', '{{%brand_to_discount}}', 'discount_id');
        $this->createIndex('idx-brand_to_discount-brand_id', '{{%brand_to_discount}}', 'brand_id');

        $this->createIndex('idx-product_to_discount-discount_id', '{{%product_to_discount}}', 'discount_id');
        $this->createIndex('idx-product_to_discount-product_id', '{{%product_to_discount}}', 'product_id');


        $this->addForeignKey('fk-product_to_discount-product', '{{%product_to_discount}}', 'product_id', '{{%products}}', 'art_id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-product_to_discount-discount', '{{%product_to_discount}}', 'discount_id', '{{%discount}}', 'id', 'CASCADE', 'RESTRICT');

        $this->addForeignKey('fk-brand_to_discount-brand', '{{%brand_to_discount}}', 'brand_id', '{{%brands}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-brand_to_discount-discount', '{{%brand_to_discount}}', 'discount_id', '{{%discount}}', 'id', 'CASCADE', 'RESTRICT');

    }

    public function safeDown()
    {
        $this->dropTable('{{%product_to_discount}}');
        $this->dropTable('{{%brand_to_discount}}');
    }


}



