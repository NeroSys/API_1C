<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%order_products}}".
 *
 * @property int $order_id
 * @property int $user_art_id
 * @property int $user_site_id
 * @property int $art_id
 * @property string $name
 * @property string $quantity
 * @property string $price
 */
class OrderProducts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_products}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'user_art_id', 'user_site_id', 'art_id'], 'required'],
            [['order_id', 'user_art_id', 'user_site_id', 'art_id'], 'integer'],
            [['quantity', 'price'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['order_id', 'user_art_id', 'user_site_id', 'art_id'], 'unique', 'targetAttribute' => ['order_id', 'user_art_id', 'user_site_id', 'art_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'user_art_id' => 'User Art ID',
            'user_site_id' => 'User Site ID',
            'art_id' => 'Art ID',
            'name' => 'Name',
            'quantity' => 'Quantity',
            'price' => 'Price',
        ];
    }
}
