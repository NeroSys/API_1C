<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%status_lang}}".
 *
 * @property string $type_id
 * @property int $lang_id
 * @property string $name
 *
 * @property StatusType $type
 * @property Language $lang
 */
class StatusLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%status_lang}}';
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
            [['type_id', 'lang_id'], 'required'],
            [['lang_id'], 'integer'],
            [['type_id', 'name'], 'string', 'max' => 255],
            [['type_id', 'lang_id'], 'unique', 'targetAttribute' => ['type_id', 'lang_id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusType::className(), 'targetAttribute' => ['type_id' => 'id_1с']],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['lang_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'type_id' => 'Type ID',
            'lang_id' => 'Lang ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(StatusType::className(), ['id_1с' => 'type_id'])->inverseOf('statusLangs');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id'])->inverseOf('statusLangs');
    }
}
