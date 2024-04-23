<div class="right-ch-sideBar">
    <div class="cart_select_items py-2">
        <?php $totalAmt = 0; ?>
        <?php if(!empty($cartData)): ?>
            <?php foreach ($cartData as $cartKey => $cartVal): ?>
                <?php if(count($cartVal) > 0): ?>
                    <?php if(isset($cartVal['cart_data']['productData'])):?>
                        <div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
                            <div class="cart_single d-flex align-items-center">
                                <div class="cart_selected_single_thumb">
                                    <a href="javaScript:;"><img src="<?php echo base_url($cartVal['cart_data']['productData']['image']); ?>" width="60" class="img-fluid" alt="" /></a></div>
                                    <div class="cart_single_caption pl-2">
                                        <h4 class="product_title fs-sm ft-medium mb-0 lh-1"><?php echo $cartVal['cart_data']['productData']['product_name']; ?></h4>
                                        <p class="mb-2">
                                            <?php if(isset($cartVal['cart_data']['productOptions'])): ?>
                                                <?php 
                                                    $productKeys = array_keys($cartVal['cart_data']['productOptions']);
                                                    $lastKey = end($productKeys);
                                                ?>
                                                <?php foreach($cartVal['cart_data']['productOptions'] as $optKey => $optVal): ?>
                                                    <span class="text-dark ft-medium small"><?php echo $optKey . ($optKey !== $lastKey ? ',' : ''); ?></span> 

                                                    <!-- <span class="text-dark small">Red, </span><span class="text-dark small">Qty:2</span> -->
                                                <?php endforeach  ?>
                                            <?php endif ?>
                                        </p>
                                        <span class="text-dark ft-medium small">Qty:<?php echo $cartVal['cart_data']['productData']['quantity']; ?></span>
                                        <h4 class="fs-md ft-medium mb-0 lh-1"><?php echo $cartVal['cart_data']['productData']['price']; ?></h4>
                                    </div>
                                </div>
                                <div class="fls_last"><button class="close_slide gray" onclick="deleteCartItem(<?php echo $cartVal['cart_data']['productData']['cartId']; ?>)"><i class="ti-close"></i></button>
                                </div>
                            </div>
                            <?php 
                                $subTotal = number_format(($cartVal['cart_data']['productData']['price'] * $cartVal['cart_data']['productData']['quantity']),2);
                                $totalAmt += $subTotal;
                            ?>
                    <?php endif ?>                    
                <?php endif ?>
            <?php endforeach ?>
            <div class="d-flex align-items-center justify-content-between br-top br-bottom px-3 py-3">
                <h6 class="mb-0">Subtotal</h6>
                    <h3 class="mb-0 ft-medium">$<?php echo $totalAmt; ?></h3>
            </div>

            <div class="cart_action px-3 py-3">
                <div class="form-group">
                        <button type="button" class="btn d-block full-width btn-dark">Checkout Now</button>
                </div>
                <div class="form-group">
                    <button type="button" class="btn d-block full-width btn-dark-light">Edit or View</button>
                </div>
            </div>
        <?php else: ?>
            <div class="d-flex align-items-center justify-content-between br-top br-bottom px-3 py-3">
                <h6 class="mb-0 ft-medium">No cart data available.</h6>
            </div>
        <?php endif ?>
    </div>
</div>