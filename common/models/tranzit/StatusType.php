<?php

namespace common\models\tranzit;

use Yii;

use common\models\StatusType as StatusTypeS;
use common\models\StatusLang as StatusLangS;

/**
 * This is the model class for table "{{%status_type}}".
 *
 * @property string $id_1c
 * @property string $name
 *
 * @property StatusLang[] $statusLangs
 * @property Language[] $langs
 * @property StatusToProduct[] $statusToProducts
 * @property Products[] $products
 */
class StatusType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%status_type}}';
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
            [['id_1c'], 'required'],
            [['id_1c', 'name'], 'string', 'max' => 255],
            [['id_1c'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_1c' => 'Id 1с',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusLangs()
    {
        return $this->hasMany(StatusLang::className(), ['type_id' => 'id_1c'])->inverseOf('type');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Language::className(), ['id' => 'lang_id'])->viaTable('{{%status_lang}}', ['type_id' => 'id_1c']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusToProducts()
    {
        return $this->hasMany(StatusToProduct::className(), ['status_id' => 'id_1c'])->inverseOf('status');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['art_id' => 'product_id'])->viaTable('{{%status_to_product}}', ['status_id' => 'id_1c']);
    }

    public function updateRecord(){
        $statusQ = StatusTypeS::find()->where(['id_1c' => $this->id_1c]);
        if($statusQ->exists()){
            $statusType = $statusQ->one();
        } else {
            $statusType = new StatusTypeS();
            $statusType->id_1c = $this->id_1c;
        }


        $statusType->name = $this->name;
        $statusType->save();

        $statusType->save();


        foreach ($this->statusLangs as $lang){
            $langQ = StatusLangS::find()->where(['type_id' => $this->id_1c])->andWhere(['lang_id' => $lang->lang_id]);

            if($langQ->exists()){
                $lngItem = $langQ->one();
            } else {
                $lngItem = new StatusLangS();
                $lngItem->type_id = $this->id_1c;
                $lngItem->lang_id = $lang->lang_id;
            }
            $lngItem->name = $lang->name;
            $lngItem->save();
        }
    }
}
