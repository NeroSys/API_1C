<?php

use yii\db\Migration;

/**
 * Class m171206_143853_product_to_category_table
 */
class m171206_143853_product_to_category_table extends Migration
{
    public function up()
    {

        $this->createTable('{{%product_to_category}}', [
            'art_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('pk-product_to_category', '{{%product_to_category}}', ['art_id', 'category_id']);

        $this->createIndex('idx-product_to_category-art_id', '{{%product_to_category}}', 'art_id');
        $this->createIndex('idx-product_to_category-category_id', '{{%product_to_category}}', 'category_id');

        $this->addForeignKey('fk-product_to_category-product', '{{%product_to_category}}', 'art_id', '{{%products}}', 'art_id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-product_to_category-catalog', '{{%product_to_category}}', 'category_id', '{{%catalog_list}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%product_to_category}}');
    }
}
