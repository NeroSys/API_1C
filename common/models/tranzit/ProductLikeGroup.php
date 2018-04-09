<?php

namespace common\models\tranzit;

use Yii;
use \common\models\ProductLikeGroup as ProductLikeGroupS;

/**
 * This is the model class for table "{{%product_like_group}}".
 *
 * @property int $union_id id группы
 * @property int $catalog_id
 * @property string $name название группы
 *
 * @property CatalogList $catalog
 * @property ProductToLikeGroup[] $productToLikeGroups
 * @property Products[] $arts
 */
class ProductLikeGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_like_group}}';
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
            [['union_id', 'catalog_id'], 'required'],
            [['union_id', 'catalog_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['union_id'], 'unique'],
            [['catalog_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogList::className(), 'targetAttribute' => ['catalog_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'union_id' => 'id группы',
            'catalog_id' => 'Catalog ID',
            'name' => 'название группы',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalog()
    {
        return $this->hasOne(CatalogList::className(), ['id' => 'catalog_id'])->inverseOf('productLikeGroups');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductToLikeGroups()
    {
        return $this->hasMany(ProductToLikeGroup::className(), ['union_id' => 'union_id'])->inverseOf('union');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArts()
    {
        return $this->hasMany(Products::className(), ['art_id' => 'art_id'])->viaTable('{{%product_to_like_group}}', ['union_id' => 'union_id']);
    }

    public function updateRecord(){
        $groupQ = ProductLikeGroupS::find()
            ->where(['union_id' => $this->union_id])
            ->andWhere(['catalog_id' => $this->catalog_id]);
        if($groupQ->exists()){
            $group = $groupQ->one();
        } else {
            $group = new ProductLikeGroupS();
            $group->union_id = $this->union_id;
            $group->catalog_id = $this->catalog_id;
        }

        $group->name = $this->name;
        $group->save();
    }

}
