<?php

namespace common\models\tranzit;

use Yii;
use common\models\ProductAttrList as ProductAttrListS;
use common\models\ProductAttrListLang as ProductAttrListLangS;

/**
 * This is the model class for table "{{%product_attr_list}}".
 *
 * @property int $attr_id id - атрибута
 * @property string $name название атрибута 
 * @property int $visible флаг отображения атрибута (1,0)
 * @property int $sort порядок сортировки
 *
 * @property ProductAttrListLang[] $productAttrListLangs
 * @property Language[] $langs
 * @property ProductAttrToFilterType[] $productAttrToFilterTypes
 * @property FilterGroupList[] $filterGroups
 */
class ProductAttrList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_attr_list}}';
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
            [['attr_id'], 'required'],
            [['attr_id', 'visible', 'sort'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['attr_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'attr_id' => 'id - атрибута',
            'name' => 'название атрибута ',
            'visible' => 'флаг отображения атрибута (1,0)',
            'sort' => 'порядок сортировки',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttrListLangs()
    {
        return $this->hasMany(ProductAttrListLang::className(), ['attr_id' => 'attr_id'])->inverseOf('attr');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Language::className(), ['id' => 'lang_id'])->viaTable('{{%product_attr_list_lang}}', ['attr_id' => 'attr_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttrToFilterTypes()
    {
        return $this->hasMany(ProductAttrToFilterType::className(), ['attr_id' => 'attr_id'])->inverseOf('attr');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilterGroups()
    {
        return $this->hasMany(FilterGroupList::className(), ['filter_group_id' => 'filter_group_id'])->viaTable('{{%product_attr_to_filter_type}}', ['attr_id' => 'attr_id']);
    }


    public function updateRecord(){
        $query = ProductAttrListS::find()->where(['attr_id' => $this->attr_id]);
        if($query->exists()){
            $attr = $query->one();
        } else {
            $attr = new ProductAttrListS;
            $attr->attr_id = $this->attr_id;
        }

        $attr->name = $this->name;
        $attr->visible = $this->visible;
        $attr->sort = $this->sort;
        $attr->save();


        foreach ($this->productAttrListLangs as $bl){
            $query = ProductAttrListLangS::find()->where(['attr_id' => $this->attr_id])->andWhere(['lang_id' => $bl->lang_id]);
            if($query->exists()){
                $lang = $query->one();
            } else {
                $lang = new ProductAttrListLangS();
                $lang->lang_id = $bl->lang_id;
                $lang->attr_id = $this->attr_id;
            }
            $lang->name = $bl->name;
            $lang->unit = $bl->unit;
            $lang->lang = $bl->lang->langName->local;
            $lang->save();
        }

    }
}
