<div class="right-ch-sideBar">
    <div class="cart_select_items py-2">
        <?php if(!empty($wishlists)): ?>
            <?php foreach($wishlists as $key => $wishlist): ?>
                <div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3 product_grid">
                    <div class="cart_single d-flex align-items-center">
                        <div class="cart_selected_single_thumb">
                            <a target="blank" href="<?php echo base_url('products/' . ($wishlist['product_details']['slug'] ?? '') . '/details') ?>"><img src="<?php echo base_url(isset($wishlist['image']) && $wishlist['image'] && count($wishlist['image']) && current($wishlist['image']) ? current($wishlist['image']) : 'images/default-image.png')?>" width="60" class="img-fluid" alt="" /></a>
                        </div>
                        <div class="cart_single_caption pl-2">
                            <a target="blank" href="<?php echo base_url('products/' . ($wishlist['product_details']['slug'] ?? '') . '/details') ?>"><h4 class="product_title fs-sm ft-medium mb-0 lh-1"><?php echo isset($wishlist['product_details']['product_name']) ? $wishlist['product_details']['product_name'] : '' ?></h4></a>
                            <h4 class="fs-md ft-medium mb-0 mt-3 lh-1">$<?php echo isset($wishlist['product_details']['price']) ? number_format($wishlist['product_details']['price'], 2) : '' ?></h4>
                        </div>
                    </div>
                    <div class="fls_last"><button class="close_slide gray remove-item-wishlist" data-id="<?php echo $key; ?>"><i class="ti-close"></i></button></div>
                </div>
            <?php endforeach ?>
        <?php else: ?>
            <div class="d-flex align-items-center justify-content-between br-top br-bottom px-3 py-3">
                <h6 class="mb-0 ft-medium">No wishlist data available.</h6>
            </div>
        <?php endif ?>
    </div>
</div>