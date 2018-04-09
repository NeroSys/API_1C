<?php

namespace common\objects;

use common\models\ProductDescriptionLang;
use common\models\ProductGallery;
use common\models\Products;

class ProductsObj extends Products
{

    public $view = '@common/objects/view/product';

    public function renderCart(){
        return \Yii::$app->view->render($this->view, ['item' => $this]);
    }

    public function getProductPrice(){
        return $this->price;
    }
    public function getProductName(){
        $lang = $this->getDataName();
        return (!empty($lang->lang_name) ? $lang->lang_name : $this->name);
    }

    public function getShortDescription(){
        $ret = $this->getProductDescriptionLang()
            ->where(['lang' => \Yii::$app->language])
            ->andWhere(['type' => ProductDescriptionLang::TYPE_SHORT])
            ->one();
        return ((is_object($ret) && $ret->canGetProperty('description')) ? preg_replace('/^<br[^>]*>/', '', $ret->description) : '');
    }

    public function getFullDescription(){
        $ret = $this->getProductDescriptionLang()
            ->where(['lang' => \Yii::$app->language])
            ->andWhere(['type' => ProductDescriptionLang::TYPE_FULL])
            ->one();

        return ((is_object($ret) && $ret->canGetProperty('description')) ? $ret->description : '');
    }

    public function getTehDescription(){
        $ret = $this->getProductDescriptionLang()
            ->where(['lang' => \Yii::$app->language])
            ->andWhere(['type' => ProductDescriptionLang::TYPE_TECHNICAL])
            ->one();

        return ((is_object($ret) && $ret->canGetProperty('description')) ? $ret->description : '');
    }


    public function getCatalogImg(){
        return (!empty($this->image) ? self::PRODUCT_CATALOG_IMG_PATH.$this->image : self::PRODUCT_NO_IMG);
    }

    public function getThumbnailImg(){
        return (!empty($this->image) ? self::PRODUCT_THUMBNAIL_IMG_PATH.$this->image : self::PRODUCT_NO_IMG);
    }

    public function getBigImg(){
        return (!empty($this->image) ? self::PRODUCT_BIG_IMG_PATH.$this->image : self::PRODUCT_NO_IMG);
    }

    public function getGalleryImg(){
        $ret = [];
        foreach ($this->productGalleries as $img){
            $ret['bigImg'][$img->id] = ProductGallery::PRODUCT_BIG_IMG_PATH.$img->image;
            $ret['thumbnailImg'][$img->id] = ProductGallery::PRODUCT_THUMBNAIL_IMG_PATH.$img->image;
        }
        return $ret;
    }


    // TODO-Bizon дореализовать в зависимости от залогиненого пользователя
    public function getCurrentPrice(){
        return $this->price;
    }

    // TODO-Bizon дореализовать в зависимости от залогиненого пользователя
    public function getCurrentOldPrice(){
        return $this->price_old;
    }

    // TODO-Bizon дореализовать в зависимости от залогиненого пользователя
    public function getCurrentPricePercent(){
        return $this->price_percent;
    }

}
