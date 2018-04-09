<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%colors_lang}}".
 *
 * @property string $id_1c
 * @property int $lang_id
 * @property string $description
 *
 * @property Colors $1c
 * @property Language $lang
 */
class ColorsLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%colors_lang}}';
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
            [['id_1c', 'lang_id'], 'required'],
            [['lang_id'], 'integer'],
            [['id_1c', 'description'], 'string', 'max' => 255],
            [['id_1c', 'lang_id'], 'unique', 'targetAttribute' => ['id_1c', 'lang_id']],
            [['id_1c'], 'exist', 'skipOnError' => true, 'targetClass' => Colors::className(), 'targetAttribute' => ['id_1c' => 'id_1c']],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['lang_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_1c' => 'Id 1c',
            'lang_id' => 'Lang ID',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function get1c()
    {
        return $this->hasOne(Colors::className(), ['id_1c' => 'id_1c'])->inverseOf('colorsLangs');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id'])->inverseOf('colorsLangs');
    }
}
