<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%status_to_product}}".
 *
 * @property int $product_id
 * @property string $status_id
 *
 * @property Products $product
 * @property StatusType $status
 */
class StatusToProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%status_to_product}}';
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
            [['product_id', 'status_id'], 'required'],
            [['product_id'], 'integer'],
            [['status_id'], 'string', 'max' => 255],
            [['product_id', 'status_id'], 'unique', 'targetAttribute' => ['product_id', 'status_id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'art_id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusType::className(), 'targetAttribute' => ['status_id' => 'id_1с']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'status_id' => 'Status ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['art_id' => 'product_id'])->inverseOf('statusToProducts');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(StatusType::className(), ['id_1с' => 'status_id'])->inverseOf('statusToProducts');
    }
}
