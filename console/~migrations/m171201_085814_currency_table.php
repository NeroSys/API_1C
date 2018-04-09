<?php

use yii\db\Migration;

/**
 * Class m171201_085814_currency_table
 */
class m171201_085814_currency_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%currency}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'code' => $this->string(50)->notNull()->defaultValue(null),
            'sign' => $this->string(11),
            'default' => $this->integer(11),

        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%currency}}');
    }
}


