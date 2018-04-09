<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%brands_to_discount}}".
 *
 * @property int $discount_id
 * @property int $brand_id
 *
 * @property Brands $brand
 * @property Discounts $discount
 */
class BrandsToDiscount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%brands_to_discount}}';
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
            [['discount_id', 'brand_id'], 'required'],
            [['discount_id', 'brand_id'], 'integer'],
            [['discount_id', 'brand_id'], 'unique', 'targetAttribute' => ['discount_id', 'brand_id']],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brands::className(), 'targetAttribute' => ['brand_id' => 'id']],
            [['discount_id'], 'exist', 'skipOnError' => true, 'targetClass' => Discounts::className(), 'targetAttribute' => ['discount_id' => 'discount_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'discount_id' => 'Discount ID',
            'brand_id' => 'Brand ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brands::className(), ['id' => 'brand_id'])->inverseOf('brandsToDiscounts');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscount()
    {
        return $this->hasOne(Discounts::className(), ['discount_id' => 'discount_id'])->inverseOf('brandsToDiscounts');
    }
}
