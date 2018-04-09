<?php

use yii\db\Migration;

/**
 * Class m171207_093211_attribute_tables
 */
class m171207_093211_attribute_tables extends Migration
{
    public function safeUp()
    {

        $tableOptions = null;
        //Опции для mysql
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_attr_list}}', [
            'attr_id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'sort' =>$this->integer(20),
            'visible' => $this->boolean()->defaultValue(0)

        ], $tableOptions);

        $this->createTable('{{%product_attr_list_lang}}', [
            'id' => $this->primaryKey(),
            'attr_id' => $this->integer(11),
            'lang_id' => $this->integer(11),
            'lang' => $this->string(50),
            'name' => $this->string()->notNull()->defaultValue(''),
            'unit' =>$this->string(),

        ], $tableOptions);


        $this->createTable('{{%product_attr_val}}', [
            'art_id' => $this->integer()->notNull(),
            'attr_id' => $this->integer()->notNull(),
            'lang_id' => $this->integer(11),
            'lang' => $this->string(50),
            'value' => $this->string()->notNull()->defaultValue(''),

        ]);


        $this->addPrimaryKey('pk-product_attr_val', '{{%product_attr_val}}', ['art_id', 'attr_id']);

        //Создание индекса
        $this->createIndex('FK_product_attr_list_lang', '{{%product_attr_list_lang}}', 'attr_id');
        $this->createIndex('idx-product_attr_val-product', '{{%product_attr_val}}', 'art_id');
        $this->createIndex('idx-product_attr_val-attribute', '{{%product_attr_val}}', 'attr_id');

        /* Связывание таблиц
        */
        $this->addForeignKey(
            'FK_product_attr_list_lang', '{{%product_attr_list_lang}}', 'attr_id', '{{%product_attr_list}}', 'attr_id', 'CASCADE', 'CASCADE'
        );
        $this->addForeignKey('fk-product_attr_val-product', '{{%product_attr_val}}', 'art_id', '{{%products}}', 'art_id', 'CASCADE', 'RESTRICT'
        );
        $this->addForeignKey('fk-product_attr_val-attribute', '{{%product_attr_val}}', 'attr_id', '{{%product_attr_list}}', 'attr_id', 'CASCADE', 'RESTRICT'
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%product_attr_list}}');
        $this->dropTable('{{%product_attr_list_lang}}');
        $this->dropTable('{{%product_attr_val}}');
    }
}




