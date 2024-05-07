<div class="product_grid card b-0">
    <?= $type[$value['type']] ?? "" ?>
    <button class="btn btn_love position-absolute ab-right snackbar-wishlist <?php echo (in_array(($value['id'] ?? ""), $wishlistProductId)) ? 'active-wishlist' : ''; ?>" data-id="<?= ($value['id'] ?? "") ?>"><i class="far fa-heart"></i></button> 
    <div class="card-body p-0">
        <div class="shop_thumb position-relative">
            <?php $images = isset($value['images']) && is_array($value['images']) ? $value['images'] : []; ?>
            <?php $image = ((isset($images[0]) && file_exists($images[0])) ? $images[0] : 'images/default-image.png') ?>
            <a class="card-img-top d-block overflow-hidden" target="blank" href="<?= base_url('products/' . $value['slug'] . '/details') ?>"><img class="card-img-top image-view" src="<?php echo base_url($image); ?>" alt="..."></a>
            <div class="edlio"><a href="#" onclick="handleQuickView(event)" data-id="<?= $value['id'] ?>" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
        </div>
    </div>
    <div class="card-footer b-0 p-0 pt-2 bg-white">
        <div class="d-flex align-items-start justify-content-between">
            <div class="text-left">
                <?php 
                    $productId = ($value['id'] ?? 0);
                    $productReview = ($productWiseReviews[$productId] ?? []);
                    $avgReview = ($productReview['avg_rating_count'] ?? 0);
                    $totalReview = ($productReview['total_reviews'] ?? 0);
                ?>
                <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                    <?php for($i=1 ; $i<=5; $i++): ?>
                        <i class="fas fa-star <?php echo ($i<=$avgReview) ? 'filled' : ''; ?>"></i>
                    <?php endfor ?>
                    <span class="small">(<?php echo $totalReview; ?> Reviews)</span>
                </div>
            </div>
        </div>
        <div class="text-left">
            <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);"><?= ucwords($value['product_name']) ?></a></h5>
            <div class="elis_rty"><span class="text-muted ft-medium line-through mr-2">$<?= number_format (($value['price'] * 2), 2,'.',',') ?></span><span class="ft-bold theme-cl fs-md">$<?= number_format ($value['price'], 2,'.',',') ?></span></div>
            <div class="d-none">
                <p class="mt-3 mb-4"><?php echo ($value['description'] ?? '')?></p>
                <a href="#" onclick="handleQuickView(event)" data-id="<?= $value['id'] ?>" class="btn stretched-link borders  snackbar-addcart">Add To Cart</a>
            </div>
        </div>
    </div>
</div>

