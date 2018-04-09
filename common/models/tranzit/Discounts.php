<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%discounts}}".
 *
 * @property int $discount_id
 * @property string $data_start
 * @property string $data_end
 * @property string $name
 * @property int $active
 * @property int $precent
 *
 * @property BrandsToDiscount[] $brandsToDiscounts
 * @property Brands[] $brands
 */
class Discounts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%discounts}}';
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
            [['data_start', 'data_end'], 'required'],
            [['data_start', 'data_end'], 'safe'],
            [['active', 'precent'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'discount_id' => 'Discount ID',
            'data_start' => 'Data Start',
            'data_end' => 'Data End',
            'name' => 'Name',
            'active' => 'Active',
            'precent' => 'Precent',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrandsToDiscounts()
    {
        return $this->hasMany(BrandsToDiscount::className(), ['discount_id' => 'discount_id'])->inverseOf('discount');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrands()
    {
        return $this->hasMany(Brands::className(), ['id' => 'brand_id'])->viaTable('{{%brands_to_discount}}', ['discount_id' => 'discount_id']);
    }
}
