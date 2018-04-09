<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%filter_type_to_catalog}}".
 *
 * @property int $filter_group_id id группы атрибутов фильтра
 * @property int $catalog_id id раздела
 */
class FilterTypeToCatalog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%filter_type_to_catalog}}';
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
            [['filter_group_id', 'catalog_id'], 'required'],
            [['filter_group_id', 'catalog_id'], 'integer'],
            [['filter_group_id', 'catalog_id'], 'unique', 'targetAttribute' => ['filter_group_id', 'catalog_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'filter_group_id' => 'id группы атрибутов фильтра',
            'catalog_id' => 'id раздела',
        ];
    }
}
