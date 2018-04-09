<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%orders}}".
 *
 * @property int $order_id
 * @property int $user_art_id id пользователя из складской программы ТК
 * @property int $user_site_id id пользователя на сайте
 * @property string $date
 * @property int $status_id
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%orders}}';
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
            [['user_art_id', 'user_site_id', 'status_id'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'user_art_id' => 'id пользователя из складской программы ТК',
            'user_site_id' => 'id пользователя на сайте',
            'date' => 'Date',
            'status_id' => 'Status ID',
        ];
    }
}
