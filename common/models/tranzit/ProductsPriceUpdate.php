<?php

namespace common\models\tranzit;

use Yii;
use \common\models\Products as ProductsS;

/**
 * This is the model class for table "{{%products_price_update}}".
 *
 * @property int $art_id артикул товара  в учетной систем
 * @property int $visible флаг отображения категории (1,0)
 * @property string $price цена для не зарегистрированого и розничнго пользователя
 * @property string $price_trade цена для оптового пользователя
 * @property int $price_trade_count Количество от которого будет учитываться скидочная цена для мелкого опта
 * @property int $price_trade_percent Число для отображения процента скидки
 * @property string $price_trade_big цена для крупнооптового пользователя
 * @property int $price_trade_big_count Количество от которого будет учитываться скидочная цена для крупного опта
 * @property string $price_old цена старая для не зарегистрированого и розничнго пользователя
 * @property string $price_old_trade цена старая для оптового пользователя
 * @property string $price_old_trade_big цена старая для крупнооптового пользователя
 */
class ProductsPriceUpdate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products_price_update}}';
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
            [['art_id'], 'required'],
            [['art_id', 'visible', 'price_percent', 'price_trade_percent', 'price_trade_big_percent'], 'integer'],
            [['price', 'price_old', 'price_trade', 'price_old_trade',  'price_trade_big', 'price_old_trade_big'], 'number'],
            [['art_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'art_id' => 'артикул товара  в учетной систем',
            'visible' => 'флаг отображения категории (1,0)',
            'price' => 'цена для не зарегистрированого и розничнго пользователя',
            'price_trade' => 'цена для оптового пользователя',
            'price_trade_count' => 'Количество от которого будет учитываться скидочная цена для мелкого опта',
            'price_trade_percent' => 'Число для отображения процента скидки',
            'price_trade_big' => 'цена для крупнооптового пользователя',
            'price_trade_big_count' => 'Количество от которого будет учитываться скидочная цена для крупного опта',
            'price_old' => 'цена старая для не зарегистрированого и розничнго пользователя',
            'price_old_trade' => 'цена старая для оптового пользователя',
            'price_old_trade_big' => 'цена старая для крупнооптового пользователя',
        ];
    }

    public function updateRecord(){
        $query = ProductsS::find()->where(['art_id' => $this->art_id]);
        if($query->exists()){
            $product = $query->one();

            $product->price_visible = $this->visible;



            $product->price = $this->price;
            $product->price_old = $this->price_old;
            $product->price_percent = $this->price_percent;
            $product->price_trade = $this->price_trade;
            $product->price_old_trade = $this->price_old_trade;
            $product->price_trade_percent = $this->price_trade_percent;
            $product->price_trade_big = $this->price_trade_big;
            $product->price_old_trade_big = $this->price_old_trade_big;
            $product->price_trade_big_percent = $this->price_trade_big_percent;
            $product->save();
        }
    }
}
