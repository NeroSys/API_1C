<?php

use yii\db\Migration;

/**
 * Class m171207_093318_filters_tables
 */
class m171207_093318_filters_tables extends Migration
{
    public function safeUp()
    {

        $tableOptions = null;
        //Опции для mysql
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        //Создание таблицы для категорий
        $this->createTable('{{%filter_type_list_lang}}', [
            'filter_group_id' => $this->integer(11),
            'lang_id' => $this->integer(11),
            'lang' => $this->string(50),
            'name' => $this->string(255)->notNull()->defaultValue('')
        ], $tableOptions);


        $this->createTable('{{%filter_type_to_catalog}}', [
            'filter_group_id' => $this->integer()->notNull(),
            'catalog_id' => $this->integer()->notNull(),
        ]);

        $this->createTable('{{%product_attr_to_filter_type}}', [
            'filter_group_id' => $this->integer()->notNull(),
            'attr_id' => $this->integer()->notNull(),
            'sort' =>$this->integer()->null(),
        ]);


        $this->addPrimaryKey('pk-filter_type_list_lang', '{{%filter_type_list_lang}}', 'filter_group_id');
        $this->addPrimaryKey('pk-filter_type_to_catalog', '{{%filter_type_to_catalog}}', ['filter_group_id', 'catalog_id']);
        $this->addPrimaryKey('pk-product_attr_to_filter_type', '{{%product_attr_to_filter_type}}', ['filter_group_id', 'attr_id']);

        //Создание индекса
        $this->createIndex('FK_filter_type_list_lang', '{{%filter_type_list_lang}}', 'filter_group_id');
        $this->createIndex('idx-filter_type_to_catalog-filter_group_id', '{{%filter_type_to_catalog}}', 'filter_group_id');
        $this->createIndex('idx-filter_type_to_catalog-catalog_id', '{{%filter_type_to_catalog}}', 'catalog_id');
        $this->createIndex('idx-product_attr_to_filter_type-filter_group_id', '{{%product_attr_to_filter_type}}', 'filter_group_id');
        $this->createIndex('idx-product_attr_to_filter_type-attr_id', '{{%product_attr_to_filter_type}}', 'attr_id');

        /* Связывание таблиц
        */
        $this->addForeignKey(
            'FK_filter_type_list_lang', '{{%filter_type_list_lang}}', 'filter_group_id', '{{%filter_group_list}}', 'filter_group_id', 'CASCADE', 'CASCADE'
        );
        $this->addForeignKey('fk-filter_type_to_catalog-group', '{{%filter_type_to_catalog}}', 'filter_group_id', '{{%filter_group_list}}', 'filter_group_id', 'CASCADE', 'RESTRICT'
        );
        $this->addForeignKey('fk-filter_type_to_catalog-catalog', '{{%filter_type_to_catalog}}', 'catalog_id', '{{%catalog_list}}', 'id', 'CASCADE', 'RESTRICT'
        );
        $this->addForeignKey('fk-product_attr_to_filter_type-group', '{{%product_attr_to_filter_type}}', 'filter_group_id', '{{%filter_group_list}}', 'filter_group_id', 'CASCADE', 'RESTRICT'
        );
        $this->addForeignKey('fk-product_attr_to_filter_type-attributes', '{{%product_attr_to_filter_type}}', 'attr_id', '{{%product_attr_list}}', 'attr_id', 'CASCADE', 'RESTRICT'
        );




    }

    public function safeDown()
    {
        $this->dropTable('{{%filter_type_list_lang}}');
        $this->dropTable('{{%filter_type_to_catalog}}');
        $this->dropTable('{{%product_attr_to_filter_type}}');
    }
}
