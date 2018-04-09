<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%diler_group}}".
 *
 * @property int $group_id
 * @property int $currency_id
 * @property string $name
 *
 * @property DilerGroupPrice[] $dilerGroupPrices
 * @property Products[] $arts
 */
class DilerGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%diler_group}}';
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
            [['group_id', 'currency_id'], 'required'],
            [['group_id', 'currency_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['group_id', 'currency_id'], 'unique', 'targetAttribute' => ['group_id', 'currency_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group_id' => 'Group ID',
            'currency_id' => 'Currency ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDilerGroupPrices()
    {
        return $this->hasMany(DilerGroupPrice::className(), ['group_id' => 'group_id'])->inverseOf('group');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArts()
    {
        return $this->hasMany(Products::className(), ['art_id' => 'art_id'])->viaTable('{{%diler_group_price}}', ['group_id' => 'group_id']);
    }
}
