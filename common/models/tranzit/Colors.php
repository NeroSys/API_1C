<?php

namespace common\models\tranzit;

use Yii;

use common\models\Colors as ColorsS;
use common\models\ColorsLang as ColorsLangS;

/**
 * This is the model class for table "{{%colors}}".
 *
 * @property string $id_1c
 * @property string $name_image
 * @property string $name
 *
 * @property ColorsLang[] $colorsLangs
 * @property Language[] $langs
 */
class Colors extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%colors}}';
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
            [['id_1c', 'name_image', 'name'], 'string', 'max' => 255],
            [['id_1c'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_1c' => 'Id 1c',
            'name_image' => 'Name Image',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColorsLangs()
    {
        return $this->hasMany(ColorsLang::className(), ['id_1c' => 'id_1c'])->inverseOf('1c');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Language::className(), ['id' => 'lang_id'])->viaTable('{{%colors_lang}}', ['id_1c' => 'id_1c']);
    }





    public function updateRecord(){
        $query = ColorsS::find()->where(['id_1c' => $this->id_1c]);
        if($query->exists()){
            $attr = $query->one();
        } else {
            $attr = new ColorsS;
            $attr->id_1c = $this->id_1c;
        }

        $attr->name = $this->name;
//        $attr->name_image = $this->name_image;
        $attr->save();


        foreach ($this->colorsLangs as $bl){
            $query = ColorsLangS::find()->where(['id_1c' => $this->id_1c])->andWhere(['lang_id' => $bl->lang_id]);
            if($query->exists()){
                $lang = $query->one();
            } else {
                $lang = new ColorsLangS();
                $lang->id_1c = $this->id_1c;
                $lang->lang_id = $bl->lang_id;
            }
            $lang->description = $bl->description;
            $lang->save();
        }

        return $attr;

    }

}
