<?php

use yii\db\Migration;

/**
 * Class m180314_083747_product_review_table
 */
class m180314_083747_product_review_table extends Migration
{
    public function safeUp()
    {

        $tableOptions = null;
        //Опции для mysql
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_reviews}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(11),
            'user_id' => $this->integer(11),
            'message' => $this->string(255),
            'rating' => $this->integer(11),
            'allow' => $this->integer(11),
            'date' => $this->date()
        ], $tableOptions);


        $this->createIndex('FK_product_reviews', '{{%product_reviews}}', 'product_id');

        $this->addForeignKey(
            'FK_p_r_products', '{{%product_reviews}}', 'product_id', '{{%products}}', 'art_id', 'CASCADE', 'CASCADE'
        );

        $this->addForeignKey(
            'FK_p_r_user', '{{%product_reviews}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE'
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%product_reviews}}');
    }
}
