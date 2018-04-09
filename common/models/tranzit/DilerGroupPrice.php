<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%diler_group_price}}".
 *
 * @property int $group_id
 * @property int $art_id
 * @property string $price
 *
 * @property DilerGroup $group
 * @property Products $art
 */
class DilerGroupPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%diler_group_price}}';
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
            [['group_id', 'art_id', 'price'], 'required'],
            [['group_id', 'art_id'], 'integer'],
            [['price'], 'number'],
            [['group_id', 'art_id'], 'unique', 'targetAttribute' => ['group_id', 'art_id']],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => DilerGroup::className(), 'targetAttribute' => ['group_id' => 'group_id']],
            [['art_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['art_id' => 'art_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group_id' => 'Group ID',
            'art_id' => 'Art ID',
            'price' => 'Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(DilerGroup::className(), ['group_id' => 'group_id'])->inverseOf('dilerGroupPrices');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArt()
    {
        return $this->hasOne(Products::className(), ['art_id' => 'art_id'])->inverseOf('dilerGroupPrices');
    }
}
