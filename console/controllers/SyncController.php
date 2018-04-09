<?php

namespace console\controllers;



use common\ftp_client\FtpClient;
use common\models\tranzit\FilterGroupList;
use common\models\tranzit\ProductBuyWithGroup;
use common\models\tranzit\Brands;
use common\models\tranzit\CatalogList;

use common\models\tranzit\Colors;
use common\models\tranzit\ProductAttrList;
use common\models\tranzit\ProductAttrVal;
use common\models\tranzit\ProductLikeGroup;
use common\models\tranzit\Products;
use common\models\tranzit\ProductsPriceUpdate;
use common\models\tranzit\ProductToCategory;
use common\models\Products as ProductsS;
use common\models\ProductGallery as ProductGalleryS;
use common\models\tranzit\StatusType;
use yii\console\Controller;
use \Exception;



/**
 * Синхронизация ДБ
 */
class SyncController extends Controller {

    private $ftpCt;




    const FTP_CLIENT_IP = '91.235.68.6';
    const FTP_LOGIN = 'temp';
    const FTP_PASSWORD = '007TeMp007';

    const PRODUCT_IMG_FILE_MASK = '*.jpg';
    const PRODUCT_IMG_PATH = '/art_img/';

    const COLOR_IMG_PATH = '/color_img/';

    const PRODUCT_MAIN_IMG = 1;


    /**
     *  Полная синхронизация
     */
    public function actionStart(){
        echo '---------------------------------------- START ----------------------------------------'.PHP_EOL;
        $start = microtime(true);
        $this->actionCatalog();
        echo "Спарвочник каталогов - OK".PHP_EOL;
        $this->actionBrands();
        echo "Спарвочник брендов - OK".PHP_EOL;
        $this->actionAttrList();
        echo "Спарвочник атрибутов - OK".PHP_EOL;
        $this->actionColorList();
        echo "Справочник цветов товара - OK".PHP_EOL;
        $this->actionProductByWithGroup();
        echo "Группы товаров с которыми покупают - OK".PHP_EOL;
        $this->actionProductLikeGroup();
        echo "Группы похожих товаров  - OK".PHP_EOL;
        $this->actionGoods();
        echo "Спарвочник товаров - OK".PHP_EOL;
        $this->actionGoodsAttr();
        echo "Спарвочник атрибутов товаров - OK".PHP_EOL;
        $this->actionPrice();
        echo "Цены товаров - OK".PHP_EOL;
        $this->actionProductToCategory();
        echo "Принадлежность товаров к категориям - OK".PHP_EOL;

        $this->actionFilterToCatalog();
        echo "Синхронизация фильтров в категориях - OK".PHP_EOL;

        $this->actionStatus();
        echo "Синхронизация статусов  - OK".PHP_EOL;

        $this->actionProductByWithGroup();
        echo "Синхронизация групп товаров с которым покупают  - OK".PHP_EOL;

        $this->actionProductLikeGroup();
        echo "Синхронизация групп похожих товаров  - OK".PHP_EOL;

        echo 'Время выполнения синхронизации: '.(microtime(true) - $start).' сек.'.PHP_EOL;
        echo '----------------------------------------  END  ----------------------------------------'.PHP_EOL;
        echo PHP_EOL;
    }

    /**
     * Синхронизация списка каталога
     */
    public function actionCatalog(){
        $start = microtime(true);
            foreach(CatalogList::find()->batch(100) as $item){
                foreach ($item as $cat){
                    $cat->updateRecord();
                }
            };
        echo 'Время синхронизации списка каталога: '.(microtime(true) - $start).' сек.'.PHP_EOL;
    }

    /**
     * Синхронизация справочника брендов
     */
    public function actionBrands(){
        $start = microtime(true);
        foreach (Brands::find()->batch(100) as $item){
            foreach ($item as $brand){
                $brand->updateRecord();
            }
        }
        echo 'Время синхронизации справочника брендов: '.(microtime(true) - $start).' сек.'.PHP_EOL;
    }

    /**
     * Синхронизация справочника атриббутов товаров
     */
    public function actionAttrList(){
        $start = microtime(true);
        foreach (ProductAttrList::find()->batch(100) as $item){
            foreach ($item as $brand){
                $brand->updateRecord();
            }
        }
        echo 'Время синхронизации справочника атриббутов товаров: '.(microtime(true) - $start).' сек.'.PHP_EOL;
    }

    /**
     * Синхронизация справочника возможных цветов
     */
    public function actionColorList(){
        $start = microtime(true);

        $this->ftpCt = new FtpClient(self::FTP_CLIENT_IP, self::FTP_LOGIN, self::FTP_PASSWORD);

        $errorFile = [];
        foreach (Colors::find()->batch(100) as $item){
            foreach ($item as $color){

                $curColor = $color->updateRecord();

                if(!empty($color->name_image) && is_object($curColor)){
                    $hash = $this->ftpCt->getHashDataFile(self::COLOR_IMG_PATH.$color->name_image);
                    if($hash != $curColor->hash){
                        $curFile = $this->ftpCt->getFtpFile(self::COLOR_IMG_PATH.$color->name_image);
                        if($curFile && $this->saveImg($curFile, $curColor::COLOR_IMG_PATH.$color->name_image, 25, 25)){
                            $curColor->name_image = $color->name_image;
                            $curColor->hash = $hash;
                            $curColor->save();
                        } else {
                            $errorFile[] =  'id: '.$curColor->id_1c.' file: '.$color->name_image;
                        }
                    }
                };

            }
        }
        if(!empty($errorFile)) echo 'Ошибочные имена файлов цветов в транзитной БД : ('.implode(', ', $errorFile).')'.PHP_EOL;
        echo 'Время синхронизации справочника возможных цветов: '.(microtime(true) - $start).' сек.'.PHP_EOL;
    }

    /**
     * Синхронизация справочника товаров
     */
    public function actionGoods(){
        $start = microtime(true);
        foreach (Products::find()->batch(100) as $item){
            foreach ($item as $good){
                $good->updateRecord();
            }
        }
        echo 'Время синхронизации справочника товаров: '.(microtime(true) - $start).' сек.'.PHP_EOL;
    }

    /**
     * Синхронизация справочника атрибутов товаров
     */
    public function actionGoodsAttr(){
        $start = microtime(true);
        foreach (ProductAttrVal::find()->batch(100) as $item){
            foreach ($item as $attr){
                $attr->updateRecord();
            }
        }
        echo 'Время синхронизации справочника атрибутов товаров: '.(microtime(true) - $start).' сек.'.PHP_EOL;
    }

    /**
     * Синхронизация цен товаров
     */
    public function actionPrice(){
        $start = microtime(true);
        foreach (ProductsPriceUpdate::find()->batch(100) as $item){
            foreach ($item as $price){
                $price->updateRecord();
            }
        }
        echo 'Время синхронизации цен товаров: '.(microtime(true) - $start).' сек.'.PHP_EOL;
    }

    /**
     * Синхронизация товаров и категорий
     */
    public function actionProductToCategory(){
        $start = microtime(true);

        foreach (ProductToCategory::find()->batch(100) as $item){
            foreach ($item as $attr){
                $attr->updateRecord();
            }
        }
        echo 'Время синхронизации товаров и категорий: '.(microtime(true) - $start).' сек.'.PHP_EOL;
    }


    /**
     * Синхронизация фильтров в категориях
     */
    public function actionFilterToCatalog(){
        $start = microtime(true);

        foreach (FilterGroupList::find()->batch(100) as $item){
            foreach ($item as $item){
                $item->updateRecord();
            }
        }
        echo 'Время синхронизации товаров и категорий: '.(microtime(true) - $start).' сек.'.PHP_EOL;
    }


    /**
     * Синхронизация групп товаров с которым покупают
     */
    public function actionProductByWithGroup(){
        $start = microtime(true);

        foreach (ProductBuyWithGroup::find()->batch(100) as $item){
            foreach ($item as $attr){
                $attr->updateRecord();
            }
        }
        echo 'Время синхронизации групп товаров с которым покупают: '.(microtime(true) - $start).' сек.'.PHP_EOL;
    }
    /**
     * Синхронизация статусов
     */
    public function actionStatus(){
        $start = microtime(true);

        foreach (StatusType::find()->batch(100) as $item){
            foreach ($item as $attr){
                $attr->updateRecord();
            }
        }
        echo 'Время синхронизации товаров и категорий: '.(microtime(true) - $start).' сек.'.PHP_EOL;
    }

    /**
     * Синхронизация групп похожих товаров
     */
    public function actionProductLikeGroup(){
        $start = microtime(true);

        foreach (ProductLikeGroup::find()->batch(100) as $item){
            foreach ($item as $attr){
                $attr->updateRecord();
            }
        }
        echo 'Время синхронизации групп похожих товаров: '.(microtime(true) - $start).' сек.'.PHP_EOL;
    }

    /**
     * Получение изображений с ФТП
     */
    public function actionUpdateImgFromFtp(){
        $start = microtime(true);
        try {
            $this->ftpCt = new FtpClient(self::FTP_CLIENT_IP, self::FTP_LOGIN, self::FTP_PASSWORD);

            $this->ftpCt->setCatalogList(self::PRODUCT_IMG_PATH.self::PRODUCT_IMG_FILE_MASK);

            if(!empty($this->ftpCt->fileList)){
                $i=0; $g=0; $z=0;


                $articlesMainImgError = [];
                $articlesGalleryImgError = [];

                foreach($this->ftpCt->fileList as $file){
                    $ietm = explode('_',$file);
                    $art_id = $ietm[0];
                    $type = $ietm[1];


                    if($type == self::PRODUCT_MAIN_IMG){
                        //Загрузка главного изображения

                        $hash = $this->ftpCt->getHashDataFile(self::PRODUCT_IMG_PATH.$file);
                        $productQ = ProductsS::find()->where(['art_id' => $art_id]);

                        if($productQ->exists()){

                            $chechHasQ = clone $productQ;
                            $chechHasQ->andWhere(['hash' => $hash]);

                            if(!$chechHasQ->exists()){

                                $curFile = $this->ftpCt->getFtpFile(self::PRODUCT_IMG_PATH.$file);

                                $this->saveImg($curFile, ProductsS::PRODUCT_BIG_IMG_PATH.$file, 1280, 854);

                                $this->saveImg($curFile, ProductsS::PRODUCT_THUMBNAIL_IMG_PATH.$file, 550, 366);

                                $this->saveImg($curFile, ProductsS::PRODUCT_CATALOG_IMG_PATH.$file, 302, 243);

                                echo $i.' - '.$art_id.PHP_EOL.PHP_EOL;
                                $product = $productQ->one();
                                $product->image = $file;
                                $product->hash = $hash;
                                $product->save();
                                $i++;

                            }
                        } else {
                            $articlesMainImgError[] = $art_id;
                        }


                    } else {
                        //Загрузка изображений галереи

                        $hash = $this->ftpCt->getHashDataFile(self::PRODUCT_IMG_PATH.$file);

                        $productQ = ProductsS::find()->where(['art_id' => $art_id]);

                        // Проверка существует ли продукт

                        if($productQ->exists()){

                            $galleryQ = ProductGalleryS::find()->where(['art_id' => $art_id])->andWhere(['image' => $file]);
                            if($galleryQ->exists()){
                                $chechHasQ = clone $galleryQ;
                                $chechHasQ->andWhere(['hash' => $hash]);

                                if(!$chechHasQ->exists()){
                                    $curFile = $this->ftpCt->getFtpFile(self::PRODUCT_IMG_PATH.$file);

                                    $this->saveImg($curFile, ProductGalleryS::PRODUCT_BIG_IMG_PATH.$file, 1280, 854);

                                    $this->saveImg($curFile, ProductGalleryS::PRODUCT_THUMBNAIL_IMG_PATH.$file, 550, 366);

                                    $productG = $galleryQ->one();

                                    echo $g.' - изображение галлереи '.$art_id.PHP_EOL.PHP_EOL;

                                    $productG->image = $file;
                                    $productG->hash = $hash;
                                    $productG->sort = $type;
                                    $productG->save();
                                    $g++;

                                }

                            } else {

                                $curFile = $this->ftpCt->getFtpFile(self::PRODUCT_IMG_PATH.$file);

                                $this->saveImg($curFile, ProductGalleryS::PRODUCT_BIG_IMG_PATH.$file, 1280, 854);

                                $this->saveImg($curFile, ProductGalleryS::PRODUCT_THUMBNAIL_IMG_PATH.$file, 550, 366);

                                echo $g.' - изображение галлереи '.$art_id.PHP_EOL.PHP_EOL;

                                $productG = new ProductGalleryS();
                                $productG->art_id = $art_id;

                                $productG->image = $file;
                                $productG->hash = $hash;
                                $productG->sort = $type;
                                $productG->save();
                                $g++;
                            }


                        } else {
                            $articlesGalleryImgError[] = $art_id;
                        }



                    }
                    $z++;
                }
                echo 'Обработано главных '.$i.' изображений и изображений галереи '.$g.'  из '.$z.' главных изображений'.PHP_EOL;
                echo 'Ошибочные артиклы товаров в главных изображениях ('.implode(',', $articlesMainImgError).')'.PHP_EOL;
                echo 'Ошибочные артиклы товаров в изображениях галлерей ('.implode(',', $articlesGalleryImgError).')'.PHP_EOL;
            }


        } catch (Exception $e){
            echo $e->getMessage().'. Процесс прерван !'.PHP_EOL;
        }

        echo 'Время получения изображений товаров: '.(microtime(true) - $start).' сек.'.PHP_EOL;
    }


    private function saveImg($curFile, $path, $width, $height){
        $img = new \Imagick();

        $img->readImageFile($curFile);

        $img->setbackgroundcolor('#FF00FF');

        $img->thumbnailImage($width, $height, true, true);

        return $img->writeImages( \Yii::getAlias('@frontend/web'.$path), true);
    }


}