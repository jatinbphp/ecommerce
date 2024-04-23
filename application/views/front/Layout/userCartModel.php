<div class="cart_select_items py-2">
    <div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">                    
        <?php if(count($getCartUsrData) > 0): ?>    
            <?php foreach($getCartUsrData as $keyCart => $valCart): ?>
                <div class="cart_single d-flex align-items-center">
                    <div class="cart_selected_single_thumb">
                        <a href="javaScript:;"><img src="<?php echo base_url('images/4.jpg')?>" width="60" class="img-fluid" alt="" /></a>
                    </div>
                    <div class="cart_single_caption pl-2">
                        <h4 class="product_title fs-sm ft-medium mb-0 lh-1">Women Striped Shirt Dress</h4>
                        <p class="mb-2"><span class="text-dark ft-medium small">36</span>, <span class="text-dark small">Red</span></p>
                        <h4 class="fs-md ft-medium mb-0 lh-1">$129</h4>
                    </div>
                </div>
                <div class="fls_last">
                    <button class="close_slide gray">
                        <i class="ti-close"></i>
                    </button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>