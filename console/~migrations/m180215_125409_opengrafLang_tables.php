<?php

use yii\db\Migration;

/**
 * Class m180215_125409_opengrafLang_tables
 */
class m180215_125409_opengrafLang_tables extends Migration
{
    public function safeUp()
    {

        $tableOptions = null;
        //Опции для mysql
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%opengraf_lang}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer(11),
            'lang_id' => $this->integer(11),
            'lang' => $this->string(50),
            'title' => $this->string(255)->notNull()->defaultValue(null),
            'keywords' => $this->string(255)->notNull()->defaultValue(null),
            'description' => $this->string(255)->notNull()->defaultValue(null)
        ], $tableOptions);


        $this->createIndex('FK_opengraf_lang', '{{%opengraf_lang}}', 'item_id');

        $this->addForeignKey(
            'FK_opengraf_lang', '{{%opengraf_lang}}', 'item_id', '{{%opengraf}}', 'id', 'CASCADE', 'CASCADE'
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%opengraf_lang}}');
    }
}
