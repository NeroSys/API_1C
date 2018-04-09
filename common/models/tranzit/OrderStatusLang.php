<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%order_status_lang}}".
 *
 * @property int $status_id
 * @property int $lang_id
 * @property string $name
 *
 * @property OrderStatusList $status
 * @property Language $lang
 */
class OrderStatusLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_status_lang}}';
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
            [['status_id', 'lang_id'], 'required'],
            [['status_id', 'lang_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['status_id', 'lang_id'], 'unique', 'targetAttribute' => ['status_id', 'lang_id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderStatusList::className(), 'targetAttribute' => ['status_id' => 'status_id']],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['lang_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'status_id' => 'Status ID',
            'lang_id' => 'Lang ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(OrderStatusList::className(), ['status_id' => 'status_id'])->inverseOf('orderStatusLangs');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id'])->inverseOf('orderStatusLangs');
    }
}
