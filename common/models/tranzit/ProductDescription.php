<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%product_description}}".
 *
 * @property int $id id описания
 * @property int $art_id id товара из таблицы products
 * @property string $name название товара
 *
 * @property Products $art
 * @property ProductDescriptionLang[] $productDescriptionLangs
 * @property Language[] $langs
 */
class ProductDescription extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_description}}';
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
            [['id', 'art_id'], 'required'],
            [['id', 'art_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id', 'art_id'], 'unique', 'targetAttribute' => ['id', 'art_id']],
            [['art_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['art_id' => 'art_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id описания',
            'art_id' => 'id товара из таблицы products',
            'name' => 'название товара',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArt()
    {
        return $this->hasOne(Products::className(), ['art_id' => 'art_id'])->inverseOf('productDescriptions');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductDescriptionLangs()
    {
        return $this->hasMany(ProductDescriptionLang::className(), ['description_id' => 'id'])->inverseOf('description0');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Language::className(), ['id' => 'lang_id'])->viaTable('{{%product_description_lang}}', ['description_id' => 'id']);
    }
}
