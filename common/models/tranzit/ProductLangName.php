<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%product_lang_name}}".
 *
 * @property int $art_id Артикул товара
 * @property int $lang_id ID - языка
 * @property string $name Перевод названия товара
 *
 * @property Products $art
 * @property Language $lang
 */
class ProductLangName extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_lang_name}}';
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
            [['art_id', 'lang_id'], 'required'],
            [['art_id', 'lang_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['art_id', 'lang_id'], 'unique', 'targetAttribute' => ['art_id', 'lang_id']],
            [['art_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['art_id' => 'art_id']],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['lang_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'art_id' => 'Артикул товара',
            'lang_id' => 'ID - языка',
            'name' => 'Перевод названия товара',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArt()
    {
        return $this->hasOne(Products::className(), ['art_id' => 'art_id'])->inverseOf('productLangNames');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id'])->inverseOf('productLangNames');
    }
}
