<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%product_attr_list_lang}}".
 *
 * @property int $attr_id id атрибута
 * @property int $lang_id id языка
 * @property string $name перевод названия атрибута
 * @property string $unit перевод единицы измерения атрибута  
 *
 * @property ProductAttrList $attr
 * @property Language $lang
 */
class ProductAttrListLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_attr_list_lang}}';
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
            [['attr_id', 'lang_id'], 'required'],
            [['attr_id', 'lang_id'], 'integer'],
            [['name', 'unit'], 'string', 'max' => 255],
            [['attr_id', 'lang_id'], 'unique', 'targetAttribute' => ['attr_id', 'lang_id']],
            [['attr_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductAttrList::className(), 'targetAttribute' => ['attr_id' => 'attr_id']],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['lang_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'attr_id' => 'id атрибута',
            'lang_id' => 'id языка',
            'name' => 'перевод названия атрибута',
            'unit' => 'перевод единицы измерения атрибута  ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttr()
    {
        return $this->hasOne(ProductAttrList::className(), ['attr_id' => 'attr_id'])->inverseOf('productAttrListLangs');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id'])->inverseOf('productAttrListLangs');
    }
}
