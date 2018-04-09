<?php

use yii\db\Migration;

/**
 * Class m171205_095553_product_table
 */
class m171205_095553_product_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%products}}', [
            'art_id' => $this->primaryKey(),
            'brand_id' => $this->integer(),
            'image' => $this->string()->defaultValue(null),
            'visible' => $this->boolean()->defaultValue(0),
            'warranty' => $this->boolean()->defaultValue(0),
            'stock' => $this->integer()->defaultValue(null),
            'status' => $this->integer()->defaultValue(null),
            'active' => $this->smallInteger(1)->notNull()->defaultValue(null),
        ]);


        $this->createIndex('idx-products-status', '{{%products}}', 'status');
        $this->createIndex('idx-products-warranty', '{{%products}}', 'warranty');
        $this->createIndex('idx-products-visible', '{{%products}}', 'visible');
        $this->createIndex('idx-products-brands', '{{%products}}', 'brand_id');


    }

    public function down()
    {
        $this->dropTable('{{%products}}');
    }
}
