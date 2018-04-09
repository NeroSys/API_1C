<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%product_description_lang}}".
 *
 * @property int $description_id
 * @property int $lang_id
 * @property string $description
 *
 * @property ProductDescription $description0
 * @property Language $lang
 */
class ProductDescriptionLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_description_lang}}';
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
            [['description_id', 'lang_id'], 'required'],
            [['description_id', 'lang_id'], 'integer'],
            [['description'], 'string'],
            [['description_id', 'lang_id'], 'unique', 'targetAttribute' => ['description_id', 'lang_id']],
            [['description_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductDescription::className(), 'targetAttribute' => ['description_id' => 'id']],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['lang_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'description_id' => 'Description ID',
            'lang_id' => 'Lang ID',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDescription0()
    {
        return $this->hasOne(ProductDescription::className(), ['id' => 'description_id'])->inverseOf('productDescriptionLangs');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id'])->inverseOf('productDescriptionLangs');
    }
}
