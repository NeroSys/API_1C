<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%product_to_buy_with_group}}".
 *
 * @property int $union_id id группы
 * @property int $art_id id товара
 *
 * @property ProductBuyWithGroup $union
 * @property Products $art
 */
class ProductToBuyWithGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_to_buy_with_group}}';
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
            [['union_id', 'art_id'], 'required'],
            [['union_id', 'art_id'], 'integer'],
            [['union_id', 'art_id'], 'unique', 'targetAttribute' => ['union_id', 'art_id']],
            [['union_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductBuyWithGroup::className(), 'targetAttribute' => ['union_id' => 'union_id']],
            [['art_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['art_id' => 'art_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'union_id' => 'id группы',
            'art_id' => 'id товара',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnion()
    {
        return $this->hasOne(ProductBuyWithGroup::className(), ['union_id' => 'union_id'])->inverseOf('productToBuyWithGroups');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArt()
    {
        return $this->hasOne(Products::className(), ['art_id' => 'art_id'])->inverseOf('productToBuyWithGroups');
    }
}
