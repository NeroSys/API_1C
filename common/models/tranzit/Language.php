<?php

namespace common\models\tranzit;

use Yii;
use common\models\Lang;

/**
 * This is the model class for table "{{%language}}".
 *
 * @property int $id id языка
 * @property string $name Название языка
 * @property string $code Код языка
 *
 * @property CatalogLang[] $catalogLangs
 * @property CatalogList[] $items
 * @property FilterTypeListLang[] $filterTypeListLangs
 * @property FilterGroupList[] $filterGroups
 * @property OrderStatusLang[] $orderStatusLangs
 * @property OrderStatusList[] $statuses
 * @property ProductAttrListLang[] $productAttrListLangs
 * @property ProductAttrList[] $attrs
 * @property ProductDescriptionLang[] $productDescriptionLangs
 * @property ProductDescription[] $descriptions
 * @property ProductLangName[] $productLangNames
 * @property Products[] $arts
 * @property StatusLang[] $statusLangs
 * @property StatusType[] $types
 */
class Language extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%language}}';
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
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 2],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id языка',
            'name' => 'Название языка',
            'code' => 'Код языка',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogLangs()
    {
        return $this->hasMany(CatalogLang::className(), ['lang_id' => 'id'])->inverseOf('lang');
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrandLangs()
    {
        return $this->hasMany(BrandsLang::className(), ['lang_id' => 'id'])->inverseOf('lang');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(CatalogList::className(), ['id' => 'item_id'])->viaTable('{{%catalog_lang}}', ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilterTypeListLangs()
    {
        return $this->hasMany(FilterTypeListLang::className(), ['lang_id' => 'id'])->inverseOf('lang');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilterGroups()
    {
        return $this->hasMany(FilterGroupList::className(), ['filter_group_id' => 'filter_group_id'])->viaTable('{{%filter_type_list_lang}}', ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderStatusLangs()
    {
        return $this->hasMany(OrderStatusLang::className(), ['lang_id' => 'id'])->inverseOf('lang');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatuses()
    {
        return $this->hasMany(OrderStatusList::className(), ['status_id' => 'status_id'])->viaTable('{{%order_status_lang}}', ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttrListLangs()
    {
        return $this->hasMany(ProductAttrListLang::className(), ['lang_id' => 'id'])->inverseOf('lang');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttrs()
    {
        return $this->hasMany(ProductAttrList::className(), ['attr_id' => 'attr_id'])->viaTable('{{%product_attr_list_lang}}', ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductDescriptionLangs()
    {
        return $this->hasMany(ProductDescriptionLang::className(), ['lang_id' => 'id'])->inverseOf('lang');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDescriptions()
    {
        return $this->hasMany(ProductDescription::className(), ['id' => 'description_id'])->viaTable('{{%product_description_lang}}', ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductLangNames()
    {
        return $this->hasMany(ProductLangName::className(), ['lang_id' => 'id'])->inverseOf('lang');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArts()
    {
        return $this->hasMany(Products::className(), ['art_id' => 'art_id'])->viaTable('{{%product_lang_name}}', ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusLangs()
    {
        return $this->hasMany(StatusLang::className(), ['lang_id' => 'id'])->inverseOf('lang');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypes()
    {
        return $this->hasMany(StatusType::className(), ['id_1с' => 'type_id'])->viaTable('{{%status_lang}}', ['lang_id' => 'id']);
    }


    public function getLangName(){
        return $this->hasOne(\common\models\Lang::className(), ['id' => 'id']);
    }

    public static function getCode($id){
        return Lang::findOne(['id' => $id])->local;
    }

}
