<div class="right-ch-sideBar">
    <div class="cart_select_items py-2">
        <?php $totalAmt = 0; ?>
        <?php if(!empty($cartData)): ?>
            <?php echo form_open_multipart('checkout', ['class' => 'form-horizontal']); ?>
                <?php foreach ($cartData as $cartKey => $cartVal): ?>
                    <?php if(count($cartVal) > 0): ?>
                        <?php if(isset($cartVal['cart_data']['productData'])):?>
                            <?php 
                                $subTotal = (($cartVal['cart_data']['productData']['price'] ?? 0) * ($cartVal['cart_data']['productData']['quantity'] ?? 0));
                                $totalAmt += $subTotal;
                            ?>
                            <div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
                                <div class="cart_single d-flex align-items-center">
                                    <div class="cart_selected_single_thumb">
                                        <a href="javaScript:;"><img src="<?php echo base_url(($cartVal['cart_data']['productData']['image'] ?? 'images/default-image.png')); ?>" width="60" class="img-fluid" alt="" /></a>
                                    </div>
                                    <div class="cart_single_caption pl-2">
                                        <h4 class="product_title fs-sm ft-medium mb-0 lh-1"><?php echo $cartVal['cart_data']['productData']['product_name']; ?></h4>
                                        <span class="text-dark">Qty:<?php echo ($cartVal['cart_data']['productData']['quantity'] ?? 0); ?> * <?php echo number_format(($cartVal['cart_data']['productData']['price'] ?? 0), 2); ?></span>
                                            <?php if(isset($cartVal['cart_data']['productOptions'])): ?>
                                                <?php 
                                                    $productKeys = array_keys($cartVal['cart_data']['productOptions']);
                                                    $lastKey = end($productKeys);
                                                ?>
                                                <?php foreach($cartVal['cart_data']['productOptions'] as $optKey => $optVal): ?>
                                                    <p class="mb-1 lh-1">
                                                        <span class="text-dark"><?php echo $optKey . ':'; ?></span> 
                                                        <span class="text-dark"><?php echo preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $optVal) ? '<i class="fas fa-square" style="color: '.$optVal.'"></i>' : $optVal; ?></span>
                                                    </p>
                                                <?php endforeach  ?>
                                            <?php endif ?>
                                        <h4 class="fs-md ft-medium mb-0 lh-1"><?php echo number_format($subTotal, 2); ?></h4>
                                    </div>
                                </div>
                                <div class="fls_last"><button type="button" class="close_slide gray" data-productId="<?php echo ($cartVal['cart_data']['productData']['id'] ?? 0) ?>" onclick="deleteCartItem(<?php echo ($cartVal['cart_data']['productData']['cartId'] ?? 0); ?>,this)"><i class="ti-close"></i></button>
                                </div>
                            </div>
                        <?php endif ?>                    
                    <?php endif ?>
                <?php endforeach ?>
                <div class="d-flex align-items-center justify-content-between br-top br-bottom px-3 py-3">
                    <h6 class="mb-0">Subtotal</h6>
                        <h3 class="mb-0 ft-medium">$<?php echo number_format($totalAmt, 2); ?></h3>
                </div>

                <div class="cart_action px-3 py-3">
                    <div class="form-group">
                        <?php echo form_submit(array('class' => 'btn d-block full-width btn-dark', 'value' => 'Checkout Now', 'onClick'=>'proceedCheckout()')); ?>
                    </div>
                </div>
                <?php echo form_input(['type' => 'hidden', 'id' => 'userCart', 'name' => 'cartData', 'value' => '',]);?>
            <?php echo form_close(); ?>
        <?php else: ?>
            <div class="d-flex align-items-center justify-content-between br-top br-bottom px-3 py-3">
                <h6 class="mb-0 ft-medium">No cart data available.</h6>
            </div>
        <?php endif ?>
    </div>
</div>
<script>
function proceedCheckout() {
    var cartData = localStorage.getItem('cartData');
    if(cartData){
        $('#userCart').val(cartData);
    }
}
</script>