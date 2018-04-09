<?php

use yii\db\Migration;

/**
 * Class m180312_150006_uder_profile_table
 */
class m180312_150006_uder_profile_table extends Migration
{
    public function safeUp()
    {

        $tableOptions = null;
        //Опции для mysql
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_profile}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11),
            'firstName' => $this->string()->defaultValue(null),
            'lastName' => $this->string()->defaultValue(null),
            'phone_1' => $this->string()->defaultValue(null),
            'phone_2' => $this->string()->defaultValue(null),
            'address' => $this->string()->defaultValue(null),
            'email_1' => $this->string()->defaultValue(null),
            'company' => $this->string()->defaultValue(null),
        ], $tableOptions);


        $this->addForeignKey(
            'FK_user_profile', '{{%user_profile}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE'
        );


    }

    public function safeDown()
    {
        $this->dropTable('{{%user_profile}}');
    }
}
