<?php

use yii\db\Migration;

/**
 * Class m171202_092207_orders_table
 */
class m171202_092207_orders_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'user_site_id' => $this->integer()->notNull()->defaultValue(null),
            'user_art' => $this->integer()->notNull()->defaultValue(null),
            'date' => $this->date(),
            'status_id' => $this->integer(11),
            'sum' => $this->float(),
            'qty' => $this->integer(11)

        ], $tableOptions);

        $this->createTable('{{%orders_products}}', [
            'order_id' => $this->primaryKey(),
            'user_site_id' => $this->integer()->notNull()->defaultValue(null),
            'user_art' => $this->integer()->notNull()->defaultValue(null),
            'art_id' => $this->integer(50),
            'name'=> $this->string(255),
            'quantity'=> $this->integer(50),
            'price'=> $this->float(),
        ], $tableOptions);


        $this->createIndex('FK_orders_user_site', '{{%orders}}', 'user_site_id');

        $this->createIndex('FK_orders_user_art', '{{%orders}}', 'user_art');

        $this->createIndex('FK_orders_date', '{{%orders}}', 'date');

        $this->createIndex('FK_orders_status', '{{%orders}}', 'status_id');


        $this->createIndex( 'idx-orders_products_user','{{%orders_products}}','user_site_id');

        $this->createIndex( 'idx-orders_products_user_art','{{%orders_products}}','user_art');

        $this->createIndex( 'idx-orders_products_user_product','{{%orders_products}}','art_id');

        /* Связывание таблиц по первичным ключам.
        */
        $this->addForeignKey(
            'FK_orders_products_orders', '{{%orders_products}}', 'order_id', '{{%orders}}', 'id', 'CASCADE', 'CASCADE');


    }

    public function safeDown()
    {
        $this->dropTable('{{%orders_products}}');
        $this->dropTable('{{%orders}}');

    }
}


