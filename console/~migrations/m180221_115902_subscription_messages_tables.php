<?php

use yii\db\Migration;

/**
 * Class m180221_115902_subscription_messages_tables
 */
class m180221_115902_subscription_messages_tables extends Migration
{
    public function safeUp()
    {

        $tableOptions = null;
        //Опции для mysql
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }


        $this->createTable('{{%subscription}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string(),
            'date' => $this->dateTime(),

        ], $tableOptions);

        $this->createTable('{{%messages}}', [
            'id' => $this->primaryKey(),
            'modelName' => $this->string(),
            'itemId' => $this->integer(11),
            'name' => $this->string(),
            'company' => $this->string()->notNull()->defaultValue(null),
            'email' => $this->string(),
            'phone' => $this->string(),
            'message' => $this->string(),
            'file' => $this->string(),
            'isVacation' => $this->boolean()->defaultValue(0),
            'isDealer' => $this->boolean()->defaultValue(0),
            'page_id' => $this->integer()->defaultValue(null),
            'date' => $this->dateTime(),
            'isNew' => $this->boolean()->defaultValue(0)

        ], $tableOptions);


    }

    public function safeDown()
    {
        $this->dropTable('{{%subscription}}');
        $this->dropTable('{{%messages}}');
    }
}
