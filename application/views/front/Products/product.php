<div class="col-xl-3 col-lg-4 col-md-6 col-6">
    <div class="product_grid card b-0">
        <div><?= $type[$value['type']] ?? "" ?></div>
        <button class="btn btn_love position-absolute ab-right snackbar-wishlist" data-id="<?= ($value['id'] ?? "") ?>"><i class="far fa-heart"></i></button> 
        <button class="btn btn_love position-absolute ab-right snackbar-wishlist <?php echo (in_array(($value['id'] ?? ""), $wishlistProductId)) ? 'active' : ''; ?>" data-id="<?= ($value['id'] ?? "") ?>"><i class="far fa-heart"></i></button> 
        <div class="card-body p-0">
            <div class="shop_thumb position-relative">
                <?php $images = isset($value['images']) && is_string($value['images']) ? explode(",", $value['images']) : []; ?>
                <a class="card-img-top d-block overflow-hidden" target="blank" href="<?= base_url('products/' . $value['id'] . '/details') ?>"><img class="card-img-top" src="<?php echo base_url($images[0] ?? ''); ?>" alt="..."></a>
                <div class="edlio"><a href="#" onclick="handleQuickView(event)" data-id="<?= $value['id'] ?>" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
            </div>
        </div>
        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
            <div class="text-left">
                <div class="text-center">
                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);"><?= ucwords($value['product_name']) ?></a></h5>
                    <div class="elis_rty"><span class="text-muted ft-medium line-through mr-2">$<?= number_format (($value['price'] * 2), 2,'.',',') ?></span><span class="ft-bold theme-cl fs-md">$<?= number_format ($value['price'], 2,'.',',') ?></span></div>
                </div>
            </div>
        </div>
    </div>
</div>