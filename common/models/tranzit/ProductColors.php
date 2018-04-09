<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%product_colors}}".
 *
 * @property int $art_id
 * @property string $color_id
 * @property string $model_id
 */
class ProductColors extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_colors}}';
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
            [['art_id', 'color_id', 'model_id'], 'required'],
            [['art_id'], 'integer'],
            [['color_id', 'model_id'], 'string', 'max' => 255],
            [['art_id', 'color_id', 'model_id'], 'unique', 'targetAttribute' => ['art_id', 'color_id', 'model_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'art_id' => 'Art ID',
            'color_id' => 'Color ID',
            'model_id' => 'Model ID',
        ];
    }
}
