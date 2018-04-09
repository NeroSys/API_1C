<?php

use yii\db\Migration;

/**
 * Class m180312_153119_rent_gallery_table
 */
class m180312_153119_rent_gallery_table extends Migration
{
    public function safeUp()
    {

        $tableOptions = null;
        //Опции для mysql
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%rent_gallery}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer(11),
            'image' => $this->string(255)->notNull()->defaultValue(null),
            'sort' => $this->integer(11)
        ], $tableOptions);


        $this->createIndex('FK_rent_gallery', '{{%rent_gallery}}', 'item_id');

        $this->addForeignKey(
            'FK_rent_gallery', '{{%rent_gallery}}', 'item_id', '{{%rent}}', 'id', 'CASCADE', 'CASCADE'
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%rent_gallery}}');
    }
}
