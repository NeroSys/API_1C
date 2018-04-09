<?php

namespace common\models\tranzit;

use Yii;
use common\models\FilterGroupList as FilterGroupListS;
use common\models\FilterTypeListLang as FilterTypeListLangS;
use common\models\FilterTypeToCatalog as FilterTypeToCatalogS; 

/**
 * This is the model class for table "{{%filter_group_list}}".
 *
 * @property int $filter_group_id id группы атрибутов фильтров
 * @property string $name название группы
 * @property int $sort индекс сортировки группы
 * @property int $visible флаг отображения группы фильтра (1,0)
 *
 * @property FilterTypeListLang[] $filterTypeListLangs
 * @property Language[] $langs
 * @property ProductAttrToFilterType[] $productAttrToFilterTypes
 * @property ProductAttrList[] $attrs
 */
class FilterGroupList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%filter_group_list}}';
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
            [['filter_group_id'], 'required'],
            [['filter_group_id', 'sort', 'visible'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['filter_group_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'filter_group_id' => 'id группы атрибутов фильтров',
            'name' => 'название группы',
            'sort' => 'индекс сортировки группы',
            'visible' => 'флаг отображения группы фильтра (1,0)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilterTypeListLangs()
    {
        return $this->hasMany(FilterTypeListLang::className(), ['filter_group_id' => 'filter_group_id'])->inverseOf('filterGroup');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Language::className(), ['id' => 'lang_id'])->viaTable('{{%filter_type_list_lang}}', ['filter_group_id' => 'filter_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttrToFilterTypes()
    {
        return $this->hasMany(ProductAttrToFilterType::className(), ['filter_group_id' => 'filter_group_id'])->inverseOf('filterGroup');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttrs()
    {
        return $this->hasMany(ProductAttrList::className(), ['attr_id' => 'attr_id'])->viaTable('{{%product_attr_to_filter_type}}', ['filter_group_id' => 'filter_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilterTypeToCatalog()
    {
        return $this->hasMany(FilterTypeToCatalog::className(), ['filter_group_id' => 'filter_group_id']);
    }



    public function updateRecord(){
        $query = FilterGroupListS::find()->where(['filter_group_id' => $this->filter_group_id]);

        if($query->exists()){
            $item = $query->one();
        } else {
            $item = new FilterGroupListS();
            $item->filter_group_id = $this->filter_group_id;
        }

        $item->name = $this->name;
        $item->sort = $this->sort;
        $item->visible = $this->visible;

        $item->save();


        foreach ($this->filterTypeListLangs as $bl){

            $query = FilterTypeListLangS::find()->where(['filter_group_id' => $this->filter_group_id])->andWhere(['lang_id' => $bl->lang_id]);

            if($query->exists()){
                $lang = $query->one();
            } else {
                $lang = new FilterTypeListLangS();
                $lang->filter_group_id = $this->filter_group_id;
                $lang->lang_id = $bl->lang_id;
                $lang->lang = $bl->lang->langName->local;
            }
            $lang->name = $bl->name;
            $lang->save();
        }


        foreach($this->filterTypeToCatalog as $filter){
            $query = FilterTypeToCatalogS::find()->where(['filter_group_id' => $this->filter_group_id])->andWhere(['catalog_id' => $filter->catalog_id]);
            if($query->exists()){
                $fitem = $query->one();
            } else {
                $fitem = new FilterTypeToCatalogS();
                $fitem->filter_group_id = $this->filter_group_id;
            }
            $fitem->catalog_id = $filter->catalog_id;
            $fitem->save();
        }
    }

}
