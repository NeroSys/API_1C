<?php

use yii\db\Migration;

/**
 * Class m180214_105224_opengraf_tables
 */
class m180214_105224_opengraf_tables extends Migration
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

        $this->createTable('{{%opengraf}}', [
            'id' => $this->primaryKey(),
            'modelName' => $this->string(),
            'itemId' => $this->integer(11)->unsigned()->defaultValue(null),
            'type' => $this->string(255)->notNull()->defaultValue(''),
            'img' => $this->string(255)->defaultValue(null),
            'url' => $this->string(255)->defaultValue(null),
            'video' => $this->string(255)->defaultValue(null),
            'audio' => $this->string(255)->defaultValue(null),
            'localeAlternative' => $this->string(255)->defaultValue(null),
            'GAuthor' => $this->string(255)->defaultValue(null),
            'GPublisher' => $this->string(255)->defaultValue(null),
            'app_id' => $this->integer(200)->notNull()->defaultValue('1'),
            'created_at' => $this->integer(11)->unsigned()->defaultValue(null)
        ], $tableOptions);


        $this->createIndex('FK_opengraf_lang', '{{%opengraf_lang}}', 'item_id');

        $this->addForeignKey(
            'FK_opengraf_lang', '{{%opengraf_lang}}', 'item_id', '{{%opengraf}}', 'id', 'CASCADE', 'CASCADE'
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%opengraf_lang}}');
        $this->dropTable('{{%opengraf}}');
    }
}
