<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%product_price}}".
 *
 * @property int $art_id Артикул товара
 * @property string $price_retail Цена для розничного пользователя
 * @property string $retail_currency Валюта для розничного пользователя
 *
 * @property Products $art
 * @property Currency $retailCurrency
 */
class ProductPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_price}}';
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
            [['price_retail'], 'number'],
            [['retail_currency'], 'string', 'max' => 3],
            [['art_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['art_id' => 'art_id']],
            [['retail_currency'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['retail_currency' => 'code']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'art_id' => 'Артикул товара',
            'price_retail' => 'Цена для розничного пользователя',
            'retail_currency' => 'Валюта для розничного пользователя',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArt()
    {
        return $this->hasOne(Products::className(), ['art_id' => 'art_id'])->inverseOf('productPrice');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRetailCurrency()
    {
        return $this->hasOne(Currency::className(), ['code' => 'retail_currency'])->inverseOf('productPrices');
    }
}
