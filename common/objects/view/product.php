<?use yii\helpers\Url;?>
<div class="goods_item" id="goods_item-<?=$item->art_id?>">
    <div class="goods_item-top">
        <div class="category">

            <a href="<?=Url::toRoute(['/catalog/view', 'slug' => $item->productToCategory->category->slug])?>"><?=$item->productToCategory->category->name?> >></a>
        </div>

        <?if(!empty($item->statusType)){?>
        <div class="stock"><span>
                <?$status = (!empty($item->statusType->statusLangs->name) ? $item->statusType->statusLangs->name : $item->statusType->name);?>
                <?=$status?></span></div>
        <?}?>
    </div>
    <div class="goods_item-center">
        <a href="<?=Url::toRoute(['/products/view', 'slug' => $item->slug])?>"><img src="<?=$item->catalogImg?>" alt="" class="goods_img"></a>
        <a href="<?=Url::toRoute(['/products/view', 'slug' => $item->slug])?>">
            <div class="goods_title"><?=$item->art_id?> <?=$item->productName?></div>
        </a>
        <?if(!empty($item->currentPrice)){?>
            <div class="goods_coast"><?=$item->currentPrice?> <span class="curancy">грн</span></div>
        <?} else {?>
            <div class="goods_coast">&nbsp;</div>
        <?}?>
        <div class="goods_rating">
            <div class="testimonials_ranck" data-score="0"></div>
        </div>
    </div>
    <div class="btn goods_item-bayBtn"  data-basket-product-id="<?=$item->art_id?>" data-basket-product-count="1">Купить</div>
</div>