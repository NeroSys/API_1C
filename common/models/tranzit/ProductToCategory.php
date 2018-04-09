<?php

namespace common\models\tranzit;

use Yii;
use common\models\ProductToCategory as ProductToCategoryS;

/**
 * This is the model class for table "{{%product_to_category}}".
 *
 * @property int $art_id id товара
 * @property int $category_id id категории
 *
 * @property Products $art
 * @property CatalogList $category
 */
class ProductToCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_to_category}}';
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
            [['art_id', 'category_id'], 'required'],
            [['art_id', 'category_id'], 'integer'],
            [['art_id', 'category_id'], 'unique', 'targetAttribute' => ['art_id', 'category_id']],
            [['art_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['art_id' => 'art_id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogList::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'art_id' => 'id товара',
            'category_id' => 'id категории',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArt()
    {
        return $this->hasOne(Products::className(), ['art_id' => 'art_id'])->inverseOf('productToCategories');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(CatalogList::className(), ['id' => 'category_id'])->inverseOf('productToCategories');
    }
    
    public function updateRecord(){
        $query = ProductToCategoryS::find()->where(['art_id' => $this->art_id])->andWhere(['category_id' => $this->category_id]);
        if(!$query->exists()){
            $item = new ProductToCategoryS();
            $item->art_id = $this->art_id;
            $item->category_id = $this->category_id;
            $item->save();
        }
    }
    
}
