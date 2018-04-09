<?php

namespace common\models\tranzit;

use common\models\BrandLang;
use Yii;
use \common\models\Brands as BrandsS;
use common\models\BrandLang as BrandLangS;

/**
 * This is the model class for table "{{%brands}}".
 *
 * @property int $id
 * @property string $name
 *
 * @property BrandsToDiscount[] $brandsToDiscounts
 * @property Discounts[] $discounts
 * @property Products[] $products
 */
class Brands extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%brands}}';
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
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrandLangs()
    {
        return $this->hasMany(BrandsLang::className(), ['brand_id' => 'id'])->inverseOf('item');
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrandsToDiscounts()
    {
        return $this->hasMany(BrandsToDiscount::className(), ['brand_id' => 'id'])->inverseOf('brand');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscounts()
    {
        return $this->hasMany(Discounts::className(), ['discount_id' => 'discount_id'])->viaTable('{{%brands_to_ discount}}', ['brand_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['brand_id' => 'id'])->inverseOf('brand');
    }


    public function updateRecord(){
        $query = BrandsS::find()->where(['id' => $this->id]);
        if($query->exists()){
            $brand = $query->one();
        } else {
            $brand = new BrandsS;
            $brand->id = $this->id;
        }

        $brand->name = $this->name;
        $brand->save();


        foreach ($this->brandLangs as $bl){
            $query = BrandLangS::find()->where(['brand_id' => $this->id])->andWhere(['lang_id' => $bl->lang_id]);
            if($query->exists()){
                $lang = $query->one();
            } else {
                $lang = new BrandLangS();
                $lang->lang_id = $bl->lang_id;
                $lang->brand_id = $this->id;
            }
            $lang->description = $bl->description;
            $lang->lang = $bl->lang->langName->local;
            $lang->save();
        }

    }

}
