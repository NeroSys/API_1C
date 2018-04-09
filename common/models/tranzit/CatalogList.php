<?php

namespace common\models\tranzit;

use Yii;

use common\models\CatalogList as CatalogListS;
use common\models\CatalogLang as CatalogLangS;

/**
 * This is the model class for table "{{%catalog_list}}".
 *
 * @property int $id id - категории
 * @property int $parent_id id – родительской категории
 * @property string $name название категории
 * @property int $visible флаг отображения категории (1,0)
 * @property int $sort индекс задающий порядок сортировки
 *
 * @property CatalogLang[] $catalogLangs
 * @property Language[] $langs
 * @property ProductBuyWithGroup[] $productBuyWithGroups
 * @property ProductLikeGroup[] $productLikeGroups
 * @property ProductToCategory[] $productToCategories
 * @property Products[] $arts
 */
class CatalogList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_list}}';
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
            [['id'], 'required'],
            [['id', 'parent_id', 'visible', 'sort'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id - категории',
            'parent_id' => 'id – родительской категории',
            'name' => 'название категории',
            'visible' => 'флаг отображения категории (1,0)',
            'sort' => 'индекс задающий порядок сортировки',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogLangs()
    {
        return $this->hasMany(CatalogLang::className(), ['item_id' => 'id'])->inverseOf('item');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Language::className(), ['id' => 'lang_id'])->viaTable('{{%catalog_lang}}', ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductBuyWithGroups()
    {
        return $this->hasMany(ProductBuyWithGroup::className(), ['catalog_id' => 'id'])->inverseOf('catalog');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductLikeGroups()
    {
        return $this->hasMany(ProductLikeGroup::className(), ['catalog_id' => 'id'])->inverseOf('catalog');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductToCategories()
    {
        return $this->hasMany(ProductToCategory::className(), ['category_id' => 'id'])->inverseOf('category');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArts()
    {
        return $this->hasMany(Products::className(), ['art_id' => 'art_id'])->viaTable('{{%product_to_category}}', ['category_id' => 'id']);
    }




    /**
     * Функции для синхронизации каталога
     *
     */
    public function updateRecord(){
        $query = CatalogListS::find()->where(['id' => $this->id]);
        if($query->exists()){
            $catItem = $query->one();
        } else {
            $catItem = new CatalogListS();
            $catItem->id = $this->id;
        }

        $catItem->name = $this->name;
        $catItem->parent_id = $this->parent_id;
        $catItem->visible = $this->visible;
        $catItem->sort = $this->sort;
        $catItem->save();

        foreach ($this->catalogLangs as $langItem){
            $query = CatalogLangS::find()->where(['item_id' => $this->id])->andWhere(['lang_id' => $langItem->lang_id]);

            if($query->exists()){
                $catLangItem = $query->one();
            } else {
                $catLangItem = new CatalogLangS();
                $catLangItem->item_id = $this->id;
                $catLangItem->lang_id = $langItem->lang_id;
            }

            $catLangItem->lang = $langItem->lang->langName->local;
            $catLangItem->lang_name = $langItem->name;
            $catLangItem->save();
        }

    }


}
