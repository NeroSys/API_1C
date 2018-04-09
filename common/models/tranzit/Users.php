<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $user_site_id id пользователя на сайте
 * @property int $user_art_id id пользователя в складской программе TK
 * @property string $email контактный email
 * @property string $name Имя
 * @property string $surname Фамилия
 * @property string $middlename Отчество
 * @property string $phone контактный телефон
 * @property string $phone_second дополнительный контактный телефон
 * @property int $region_id id региона
 * @property int $city_id id города
 * @property int $tk_update_fl Флаг изменения данных складской программой
 * @property int $site_update_fl Флаг изменения данных пользователем
 *
 * @property  $region
 * @property  $city
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
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
            [['user_site_id', 'user_art_id', 'phone'], 'required'],
            [['user_site_id', 'user_art_id', 'region_id', 'city_id', 'tk_update_fl', 'site_update_fl'], 'integer'],
            [['email', 'name', 'surname', 'middlename', 'phone', 'phone_second'], 'string', 'max' => 255],
            [['user_site_id', 'user_art_id'], 'unique', 'targetAttribute' => ['user_site_id', 'user_art_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_site_id' => 'id пользователя на сайте',
            'user_art_id' => 'id пользователя в складской программе TK',
            'email' => 'контактный email',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'middlename' => 'Отчество',
            'phone' => 'контактный телефон',
            'phone_second' => 'дополнительный контактный телефон',
            'region_id' => 'id региона',
            'city_id' => 'id города',
            'tk_update_fl' => 'Флаг изменения данных складской программой',
            'site_update_fl' => 'Флаг изменения данных пользователем',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        ->inverseOf('users');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        ->inverseOf('users0');
    }
}
