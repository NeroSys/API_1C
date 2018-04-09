<?php

use yii\db\Migration;

/**
 * Class m171205_121130_product_lang_tables
 */
class m171205_121130_product_lang_tables extends Migration
{
    public function safeUp()
    {

        $tableOptions = null;
        //Опции для mysql
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_lang_name}}', [
            'id' => $this->primaryKey(),
            'art_id' => $this->integer(11),
            'lang_id' => $this->integer(11),
            'lang' => $this->string(50),
            'lang_name' => $this->string(255)->notNull()->defaultValue('')
        ], $tableOptions);

        $this->createTable('{{%product_description_lang}}', [
            'id' => $this->primaryKey(),
            'art_id' => $this->integer(11),
            'lang_id' => $this->integer(11),
            'lang' => $this->string(50),
            'description' => $this->string(255)->notNull()->defaultValue('')
        ], $tableOptions);



        $this->createIndex('product_lang_name', '{{%product_lang_name}}', 'art_id');

        $this->createIndex('product_description_lang', '{{%product_description_lang}}', 'art_id');

        /* Связывание таблицы product_lang_name с таблицей products по первичным ключам.
        * При удалении записи в таблице products, записи из графы art_id таблицы product_lang_name будут удалены,
        * а при обновлении записи в таблице products, записи из графы art_id таблицы product_lang_name будут обновлены соответственно.
        */
        $this->addForeignKey(
            'fk_product_lang_name', '{{%product_lang_name}}', 'art_id', '{{%products}}', 'art_id', 'CASCADE', 'CASCADE'
        );

        /* Связывание таблицы product_description_lang с таблицей products по первичным ключам.
        * При удалении записи в таблице products, записи из графы art_id таблицы product_description_lang будут удалены,
        * а при обновлении записи в таблице products, записи из графы art_id таблицы product_description_lang будут обновлены соответственно.
        */
        $this->addForeignKey(
            'fk_product_description_lang', '{{%product_description_lang}}', 'art_id', '{{%products}}', 'art_id', 'CASCADE', 'CASCADE'
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%product_lang_name}}');
        $this->dropTable('{{%product_description_lang}}');
    }
}
