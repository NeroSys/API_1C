<?php

use yii\db\Migration;

/**
 * Class m171207_082601_filter_table
 */
class m171207_082601_filter_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%filter_group_list}}', [
            'filter_group_id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'sort' =>$this->integer(20),
            'visible' => $this->boolean()->defaultValue(0)

        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%filter_group_list}}');
    }
}

