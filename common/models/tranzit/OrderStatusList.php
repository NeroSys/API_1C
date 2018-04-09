<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%order_status_list}}".
 *
 * @property int $status_id id статуса в складской программе TK
 * @property string $name название статуса
 *
 * @property OrderStatusLang[] $orderStatusLangs
 * @property Language[] $langs
 */
class OrderStatusList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_status_list}}';
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
            [['status_id'], 'required'],
            [['status_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['status_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'status_id' => 'id статуса в складской программе TK',
            'name' => 'название статуса',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderStatusLangs()
    {
        return $this->hasMany(OrderStatusLang::className(), ['status_id' => 'status_id'])->inverseOf('status');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Language::className(), ['id' => 'lang_id'])->viaTable('{{%order_status_lang}}', ['status_id' => 'status_id']);
    }
}
