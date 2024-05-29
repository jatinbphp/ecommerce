<?php // echo "<pre>"; print_r($cartData); echo "</pre>"; ?>
<?php $this->load->view('Breadcrumb',['current' => ($title ?? '')]); ?>
<section class="middle">
<div class="container">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="text-center d-block mb-5">
                <h2><?php echo ($title ?? '') ?></h2>
            </div>
        </div>
    </div>
    <div class="row justify-content-between">
        <?php if($cartData && count($cartData)): ?>
            <div class="col-12 col-lg-8 col-md-12">
                <ul class="shopping-cart-list">
                    <?php $totalAmt = 0; ?> 
                    <?php foreach($cartData as $data): ?>
                        <?php if(isset($data['cart_data']['productData'])):?>
                            <?php 
                                $subTotal = (($data['cart_data']['productData']['price'] ?? 0) * ($data['cart_data']['productData']['quantity'] ?? 0));
                                $totalAmt += $subTotal;
                            ?>
                            <li>
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <?php $image = (isset($data['cart_data']['productData']['image']) && file_exists($data['cart_data']['productData']['image']) ? $data['cart_data']['productData']['image'] : 'images/default-image.png') ?>
                                        <a target="_blank" href="<?php echo base_url('products/' . ($data['cart_data']['productData']['slug'] ?? '') . '/details') ?>"><img src="<?php echo base_url($image); ?>" class="img-fluid" alt="" /></a>
                                    </div>
                                    <div class="col d-flex align-items-center justify-content-between">
                                        <div class="cart_single_caption">
                                        <a target="_blank" href="<?php echo base_url('products/' . ($data['cart_data']['productData']['slug'] ?? '') . '/details') ?>"><h4 class="product_title fs-md ft-medium mb-1 lh-1"><?php echo ($data['cart_data']['productData']['product_name'] ?? ''); ?></h4></a>
                                            <p class="mb-1 lh-1"><span class="text-dark">Qty:<?php echo ($data['cart_data']['productData']['quantity'] ?? 0); ?> * <?php echo number_format(($data['cart_data']['productData']['price'] ?? 0), 2); ?></span></p>
                                            <?php if(isset($data['cart_data']['productOptions'])): ?>
                                                <?php foreach($data['cart_data']['productOptions'] as $optKey => $optVal): ?>
                                                    <p class="mb-1 lh-1">
                                                        <span class="text-dark">
                                                            <?php echo $optKey . ':'; ?>
                                                            <?php echo preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $optVal) ? '<i class="fas fa-square" style="color: '.$optVal.'"></i>' : $optVal; ?>
                                                        </span>
                                                    </p>
                                                <?php endforeach  ?>
                                            <?php endif ?>
                                            <h4 class="fs-md ft-medium mb-0 lh-1">Total:<?php echo number_format($subTotal, 2); ?></h4>
                                        </div>
                                        <div class="fls_last"><button type="button" class="close_slide gray" data-productId="<?php echo ($data['cart_data']['productData']['id'] ?? 0) ?>" onclick="deleteShoppingCartItem(<?php echo ($data['cart_data']['productData']['cartId'] ?? 0); ?>,this)"><i class="ti-close"></i></button></div>
                                    </div>
                                </div>
                                                </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                                                </ul>
            </div>
            <div class="col-12 col-md-12 col-lg-4">
                <div class="card mb-4 gray mfliud">
                    <div class="card-body">
                        <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">
                            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                <span>Subtotal</span> <span class="ml-auto text-dark ft-medium">$<?php echo number_format($totalAmt, 2); ?></span>
                            </li>
                            <!-- <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                <span>Tax</span> <span class="ml-auto text-dark ft-medium">$10.10</span>
                            </li> -->
                            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                <span>Total</span> <span class="ml-auto text-dark ft-medium">$<?php echo number_format($totalAmt, 2); ?></span>
                            </li>
                            <li class="list-group-item fs-sm text-center">
                                Shipping cost calculated at Checkout *
                            </li>
                        </ul>
                    </div>
                </div>
                <a class="btn btn-block btn-dark mb-3" href="<?php echo base_url('checkout') ?>">Proceed to Checkout</a>
                <a class="btn-link text-dark ft-medium" href="<?php echo base_url('shop'); ?>">
                <i class="ti-back-left mr-2"></i> Continue Shopping
                </a>
            </div>
        <?php else: ?>
            <div class="align-items-center justify-content-between px-3 py-3 col-12">
                <h6 class="mb-0 ft-medium text-center">No cart data available.</h6>
            </div>
        <?php endif; ?>
    </div>
</div>
</section>
<script>
    function deleteShoppingCartItem(cartId, button){
        swal({
            title: "Are you sure?",
            text: "You want to delete Cart item ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'No, cancel',
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function(isConfirm) {
            if (isConfirm) {
                if(cartId == 0){
                    var productId = $(button).attr('data-productId');
                    var existingCartData = localStorage.getItem('cartData') ? JSON.parse(localStorage.getItem('cartData')) : [];
                    var filteredCartData = existingCartData.filter(function(item) {
                        return item.product_id !== productId;
                    });
                    localStorage.setItem('cartData', JSON.stringify(filteredCartData));
                    var data =  localStorage.getItem('cartData');
                    if(data){
                        $('.user-cart-counter').text(JSON.parse(data).length);
                    }
                    updateCartData();
                } else {
                    var tockenName = getTockenName();
                    var tockenValue = getTockenValue();
                    var dataObj = {cartId: cartId};
                    dataObj[tockenName] = tockenValue;
                    $.ajax({
                        url: baseUrl+"cart/delete-user-item",
                        method: 'POST',
                        data: dataObj,
                        success: function(response) {
                            $(".user-cart-counter").html(response.cartCounter);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('AJAX Error:', textStatus, errorThrown);
                        }
                    }).always(function (dataOrjqXHR, textStatus, jqXHRorErrorThrown) {
                        updateCsrfToken();
                    });
                }
                location.reload();
            } else {
                swal("Cancelled", "Your Data is Safe.", "error");
            }
        });
    }
</script>
