<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%brands_lang}}".
 *
 * @property int $brand_id
 * @property int $lang_id
 * @property string $description
 * @property Language $lang
 */
class BrandsLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%brands_lang}}';
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
            [['brand_id', 'lang_id'], 'required'],
            [['brand_id', 'lang_id'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['brand_id', 'lang_id'], 'unique', 'targetAttribute' => ['brand_id', 'lang_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'brand_id' => 'Brand ID',
            'lang_id' => 'Lang ID',
            'description' => 'Description',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Brands::className(), ['id' => 'brand_id'])->inverseOf('brandLangs');
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id'])->inverseOf('brandLangs');
    }

}
