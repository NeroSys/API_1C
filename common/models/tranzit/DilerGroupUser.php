<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%diler_group_user}}".
 *
 * @property int $group_id
 * @property int $user_site_id
 * @property int $user_art
 */
class DilerGroupUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%diler_group_user}}';
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
            [['group_id', 'user_site_id', 'user_art'], 'required'],
            [['group_id', 'user_site_id', 'user_art'], 'integer'],
            [['group_id', 'user_site_id', 'user_art'], 'unique', 'targetAttribute' => ['group_id', 'user_site_id', 'user_art']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group_id' => 'Group ID',
            'user_site_id' => 'User Site ID',
            'user_art' => 'User Art',
        ];
    }
}
