<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%product_attr_to_filter_type}}".
 *
 * @property int $filter_group_id id группы атрибутов фильтров
 * @property int $attr_id id атрибута
 * @property int $sort индекс сортировки вывода фильтра
 *
 * @property FilterGroupList $filterGroup
 * @property ProductAttrList $attr
 */
class ProductAttrToFilterType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_attr_to_filter_type}}';
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
            [['filter_group_id', 'attr_id'], 'required'],
            [['filter_group_id', 'attr_id', 'sort'], 'integer'],
            [['filter_group_id', 'attr_id'], 'unique', 'targetAttribute' => ['filter_group_id', 'attr_id']],
            [['filter_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => FilterGroupList::className(), 'targetAttribute' => ['filter_group_id' => 'filter_group_id']],
            [['attr_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductAttrList::className(), 'targetAttribute' => ['attr_id' => 'attr_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'filter_group_id' => 'id группы атрибутов фильтров',
            'attr_id' => 'id атрибута',
            'sort' => 'индекс сортировки вывода фильтра',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilterGroup()
    {
        return $this->hasOne(FilterGroupList::className(), ['filter_group_id' => 'filter_group_id'])->inverseOf('productAttrToFilterTypes');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttr()
    {
        return $this->hasOne(ProductAttrList::className(), ['attr_id' => 'attr_id'])->inverseOf('productAttrToFilterTypes');
    }
}
