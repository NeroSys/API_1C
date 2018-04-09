<?php

namespace common\models\tranzit;

use Yii;

use common\models\Products as ProductsS;
use \common\models\ProductLangName as ProductLangNameS;
use \common\models\ProductToBuyWithGroup as ProductToBuyWithGroupS;
use \common\models\ProductToLikeGroup as ProductToLikeGroupS;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property int $art_id артикул товара  в учетной систем
 * @property int $brand_id Бренд
 * @property string $name название товара
 * @property int $visible флаг отображения категории (1,0)
 * @property int $warranty Гарантия флаг
 * @property int $stock Остаток
 *
 * @property DilerGroupPrice[] $dilerGroupPrices
 * @property DilerGroup[] $groups
 * @property ProductDescription[] $productDescriptions
 * @property ProductLangName[] $productLangNames
 * @property Language[] $langs
 * @property ProductPrice $productPrice
 * @property ProductToBuyWithGroup[] $productToBuyWithGroups
 * @property ProductBuyWithGroup[] $unions
 * @property ProductToCategory[] $productToCategories
 * @property CatalogList[] $categories
 * @property ProductToLikeGroup[] $productToLikeGroups
 * @property ProductLikeGroup[] $unions0
 * @property Brands $brand
 * @property StatusToProduct[] $statusToProducts
 * @property StatusType[] $statuses
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products}}';
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
            [['art_id'], 'required'],
            [['art_id', 'brand_id', 'visible', 'warranty', 'stock'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['art_id'], 'unique'],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brands::className(), 'targetAttribute' => ['brand_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'art_id' => 'артикул товара  в учетной систем',
            'brand_id' => 'Бренд',
            'name' => 'название товара',
            'visible' => 'флаг отображения категории (1,0)',
            'warranty' => 'Гарантия флаг',
            'stock' => 'Остаток',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDilerGroupPrices()
    {
        return $this->hasMany(DilerGroupPrice::className(), ['art_id' => 'art_id'])->inverseOf('art');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(DilerGroup::className(), ['group_id' => 'group_id'])->viaTable('{{%diler_group_price}}', ['art_id' => 'art_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductDescriptions()
    {
        return $this->hasMany(ProductDescription::className(), ['art_id' => 'art_id'])->inverseOf('art');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductLangNames()
    {
        return $this->hasMany(ProductLangName::className(), ['art_id' => 'art_id'])->inverseOf('art');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Language::className(), ['id' => 'lang_id'])->viaTable('{{%product_lang_name}}', ['art_id' => 'art_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductPrice()
    {
        return $this->hasOne(ProductPrice::className(), ['art_id' => 'art_id'])->inverseOf('art');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductToBuyWithGroups()
    {
        return $this->hasMany(ProductToBuyWithGroup::className(), ['art_id' => 'art_id'])->inverseOf('art');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnions()
    {
        return $this->hasMany(ProductBuyWithGroup::className(), ['union_id' => 'union_id'])->viaTable('{{%product_to_buy_with_group}}', ['art_id' => 'art_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductToCategories()
    {
        return $this->hasMany(ProductToCategory::className(), ['art_id' => 'art_id'])->inverseOf('art');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(CatalogList::className(), ['id' => 'category_id'])->viaTable('{{%product_to_category}}', ['art_id' => 'art_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductToLikeGroups()
    {
        return $this->hasMany(ProductToLikeGroup::className(), ['art_id' => 'art_id'])->inverseOf('art');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnions0()
    {
        return $this->hasMany(ProductLikeGroup::className(), ['union_id' => 'union_id'])->viaTable('{{%product_to_like_group}}', ['art_id' => 'art_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brands::className(), ['id' => 'brand_id'])->inverseOf('products');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusToProducts()
    {
        return $this->hasOne(StatusToProduct::className(), ['product_id' => 'art_id'])->inverseOf('product');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatuses()
    {
        return $this->hasMany(StatusType::className(), ['id_1с' => 'status_id'])->viaTable('{{%status_to_product}}', ['product_id' => 'art_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(ProductColors::className(), ['art_id' => 'art_id']);
    }





    public function updateRecord(){
        $query = ProductsS::find()->where(['art_id' => $this->art_id]);
        if($query->exists()){
            $attr = $query->one();
        } else {
            $attr = new ProductsS;
            $attr->art_id = $this->art_id;
        }

        $attr->color_id = $this->color->color_id;

        $attr->color_group = $this->color->model_id;

        $attr->brand_id = $this->brand_id;
        $attr->visible = $this->visible;
        $attr->warranty = $this->warranty;
        $attr->stock = $this->stock;
        $attr->name = $this->name;
        $attr->status_id = (!empty($this->statusToProducts) ? $this->statusToProducts->status_id : NULL);

        $attr->save();

        // Апдейт переводов названия товара
        $plangNameQ = ProductLangName::find()->where(['art_id' => $this->art_id]);

        if($plangNameQ->exists()){

            foreach ($plangNameQ->all() as $langName){
                $plQ = ProductLangNameS::find()->where(['art_id' => $this->art_id])->andWhere(['lang_id' => $langName->lang_id]);
                if($plQ->exists()){
                    $pl = $plQ->one();
                } else {
                    $pl = new ProductLangNameS();
                    $pl->art_id = $this->art_id;
                    $pl->lang_id = $langName->lang_id;
                }

                $pl->lang_name = $langName->name;
                $pl->save();
            }
        }
        // Апдейт переводов названия товара

        // Апдейт принадлежности товара к группам скоторым он покупается
        // Удаление товара из всех групп
        ProductToBuyWithGroupS::deleteAll(['art_id' => $this->art_id]);

        foreach ($this->productToBuyWithGroups as $item){
            $ptog = new ProductToBuyWithGroupS();
            $ptog->art_id = $this->art_id;
            $ptog->union_id = $item->union_id;
            $ptog->save();
        }
        // Апдейт принадлежности товара к группам скоторым он покупается

        // Апдейт принадлежности товара к группам похожих
        // Удаление товара из всех групп
        ProductToLikeGroupS::deleteAll(['art_id' => $this->art_id]);

        foreach ($this->productToLikeGroups as $item){
            $ptog = new ProductToLikeGroupS();
            $ptog->art_id = $this->art_id;
            $ptog->union_id = $item->union_id;
            $ptog->save();
        }
        // Апдейт принадлежности товара к группам похожих
    }

}
