<?php

use yii\db\Migration;

/**
 * Class m171130_132145_brands_table
 */
class m171130_132145_brands_table extends Migration
{
    public function safeUp()
    {

        $tableOptions = null;
        //Опции для mysql
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        //Создание таблицы для переводов
        $this->createTable('{{%brand_lang}}', [
            'id' => $this->primaryKey(),
            'brand_id' => $this->integer(11),
            'lang_id' => $this->integer(11),
            'lang' => $this->string(50),
            'description' => $this->string(255)->notNull()->defaultValue('')
        ], $tableOptions);

        //Создание таблиц brands
        $this->createTable('{{%brands}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->defaultValue(''),
            'image_logo' => $this->string(255)->defaultValue(null),
            'image_small' => $this->string(255)->defaultValue(null),
            'image_large' => $this->string(255)->defaultValue(null)
        ], $tableOptions);


        //Создание индекса в таблице brand_lang для ячейки 'brand_id'
        $this->createIndex('FK_brand_lang', '{{%brand_lang}}', 'brand_id');

        /* Связывание таблицы brand_lang с таблицей brands по первичным ключам.
        * При удалении записи в таблице brands, записи из графы brand_id таблицы brand_lang будут удалены,
        * а при обновлении записи в таблице brands, записи из графы brand_id таблицы brand_lang будут обновлены соответственно.
        */
        $this->addForeignKey(
            'FK_brand_lang', '{{%brand_lang}}', 'brand_id', '{{%brands}}', 'id', 'CASCADE', 'CASCADE'
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%brand_lang}}');
        $this->dropTable('{{%brands}}');
    }
}
