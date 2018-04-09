<?php

namespace common\models\tranzit;

use Yii;
use common\models\ProductAttrVal as ProductAttrValS;
use common\models\ProductDescriptionLang as ProductDescriptionLangS;

/**
 * This is the model class for table "{{%product_attr_val}}".
 *
 * @property int $art_id id товара
 * @property int $attr_id id атрибута
 * @property int $lang_id id языка
 * @property string $value значение атрибута
 *
 * @property Products $art
 * @property Language $lang
 * @property ProductAttrList $attr
 */
class ProductAttrVal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_attr_val}}';
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
            [['art_id', 'attr_id', 'lang_id'], 'required'],
            [['art_id', 'attr_id', 'lang_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['art_id', 'attr_id', 'lang_id'], 'unique', 'targetAttribute' => ['art_id', 'attr_id', 'lang_id']],
            [['art_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['art_id' => 'art_id']],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['lang_id' => 'id']],
            [['attr_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductAttrList::className(), 'targetAttribute' => ['attr_id' => 'attr_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'art_id' => 'id товара',
            'attr_id' => 'id атрибута',
            'lang_id' => 'id языка',
            'value' => 'значение атрибута',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArt()
    {
        return $this->hasOne(Products::className(), ['art_id' => 'art_id'])->inverseOf('productAttrVals');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id'])->inverseOf('productAttrVals');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttr()
    {
        return $this->hasOne(ProductAttrList::className(), ['attr_id' => 'attr_id'])->inverseOf('productAttrVals');
    }

    public function updateRecord(){
        if($this->attr_id == '100054'){
            // Краткое описание
            $this->updateDescription(ProductDescriptionLangS::TYPE_SHORT);
        }elseif($this->attr_id == '100070'){
            // Полное описание
            $this->updateDescription(ProductDescriptionLangS::TYPE_FULL);
        }elseif($this->attr_id == '100065'){
            // Тех. Характеристики
            $this->updateDescription(ProductDescriptionLangS::TYPE_TECHNICAL);
        } else {
            $query = ProductAttrValS::find()
                ->where(['art_id' => $this->art_id])
                ->andWhere(['attr_id' => $this->attr_id])
                ->andWhere(['lang_id' => $this->lang_id]);

            if($query->exists()){
                $attr = $query->one();
            } else {
                $attr = new ProductAttrValS;
                $attr->art_id = $this->art_id;
                $attr->attr_id = $this->attr_id;
                $attr->lang_id = $this->lang_id;
            }
            $attr->value = $this->value;
            $attr->lang = Language::getCode($this->lang_id);
            $attr->save();
        }
    }




    private function updateDescription($type){
        $descQ = ProductDescriptionLangS::find()
            ->where(['art_id' => $this->art_id])
            ->andWhere(['type' => $type])
            ->andWhere(['lang_id' => $this->lang_id]);
        if($descQ->exists()){
            $description = $descQ->one();
        } else {
            $description = new ProductDescriptionLangS();
            $description->art_id = $this->art_id;
            $description->lang_id = $this->lang_id;
            $description->lang = Language::getCode($this->lang_id);
            $description->type = $type;
        }
        $description->description = $this->value;
        $description->save();
    }

}
