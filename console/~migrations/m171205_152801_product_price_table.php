<?php

use yii\db\Migration;

/**
 * Class m171205_152801_product_price_table
 */
class m171205_152801_product_price_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_price}}', [

            'id' => $this->primaryKey(),
            'art_id' => $this->integer(50),
            'price_retail' => $this->float()->defaultValue(null),
            'retail_currency' => $this->integer(10)->defaultValue(null),
            'price_diller_1' => $this->float()->defaultValue(null),
            'price_diller_currency_1' => $this->integer(10)->defaultValue(null),
            'price_diller_2' => $this->float()->defaultValue(null),
            'price_diller_currency_2' => $this->integer(10)->defaultValue(null),
            'price_diller_3' => $this->float()->defaultValue(null),
            'price_diller_currency_3' => $this->integer(10)->defaultValue(null)

        ], $tableOptions);

        $this->createIndex('product_price_retail', '{{%product_price}}', 'price_retail');

        $this->createIndex('product_price_diller1', '{{%product_price}}', 'price_diller_1');

        $this->createIndex('product_price_diller2', '{{%product_price}}', 'price_diller_2');

        $this->createIndex('product_price_diller3', '{{%product_price}}', 'price_diller_3');

        /* Связывание таблицы product_price с таблицей products по первичным ключам.
        * При удалении записи в таблице products, записи из графы art_id таблицы product_price будут удалены,
        * а при обновлении записи в таблице products, записи из графы art_id таблицы product_price будут обновлены соответственно.
        */
        $this->addForeignKey(
            'fk_product_product_price', '{{%product_price}}', 'art_id', '{{%products}}', 'art_id', 'CASCADE', 'CASCADE'
        );


    }

    public function safeDown()
    {
        $this->dropTable('{{%product_price}}');
    }
}


