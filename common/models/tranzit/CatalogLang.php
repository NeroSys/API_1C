<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%catalog_lang}}".
 *
 * @property int $item_id
 * @property int $lang_id
 * @property string $name
 *
 * @property CatalogList $item
 * @property Language $lang
 */
class CatalogLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_lang}}';
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
            [['item_id', 'lang_id'], 'required'],
            [['item_id', 'lang_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['item_id', 'lang_id'], 'unique', 'targetAttribute' => ['item_id', 'lang_id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogList::className(), 'targetAttribute' => ['item_id' => 'id']],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['lang_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => 'Item ID',
            'lang_id' => 'Lang ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(CatalogList::className(), ['id' => 'item_id'])->inverseOf('catalogLangs');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id'])->inverseOf('catalogLangs');
    }
}
