<?php

use yii\db\Migration;

/**
 * Class m171201_092057_discount_table
 */
class m171201_092057_discount_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%discount}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'date_start' => $this->date(),
            'date_end' => $this->date(),
            'active' => $this->boolean()->defaultValue(0),
            'percent' => $this->integer(11),

        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%discount}}');
    }
}
