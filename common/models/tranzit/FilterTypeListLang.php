<?php

namespace common\models\tranzit;

use Yii;

/**
 * This is the model class for table "{{%filter_type_list_lang}}".
 *
 * @property int $filter_group_id id группы фильтра
 * @property int $lang_id id языка
 * @property string $name перевод название группы атрибутов фильтра
 *
 * @property FilterGroupList $filterGroup
 * @property Language $lang
 */
class FilterTypeListLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%filter_type_list_lang}}';
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
            [['filter_group_id', 'lang_id'], 'required'],
            [['filter_group_id', 'lang_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['filter_group_id', 'lang_id'], 'unique', 'targetAttribute' => ['filter_group_id', 'lang_id']],
            [['filter_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => FilterGroupList::className(), 'targetAttribute' => ['filter_group_id' => 'filter_group_id']],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['lang_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'filter_group_id' => 'id группы фильтра',
            'lang_id' => 'id языка',
            'name' => 'перевод название группы атрибутов фильтра',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilterGroup()
    {
        return $this->hasOne(FilterGroupList::className(), ['filter_group_id' => 'filter_group_id'])->inverseOf('filterTypeListLangs');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id'])->inverseOf('filterTypeListLangs');
    }
}
