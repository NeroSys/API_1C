<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%product_to_discount}}".
 *
 * @property int $discount_id
 * @property int $product_id
 */
class ProductToDiscount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_to_discount}}';
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
            [['discount_id', 'product_id'], 'required'],
            [['discount_id', 'product_id'], 'integer'],
            [['discount_id', 'product_id'], 'unique', 'targetAttribute' => ['discount_id', 'product_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'discount_id' => 'Discount ID',
            'product_id' => 'Product ID',
        ];
    }
}
