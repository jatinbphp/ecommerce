<?php $subTotal = 0; ?>
<div class="d-block mb-3">
    <h5 class="mb-4">Order Items (<?= count($cart_products) ?>)</h5>
    <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x mb-4">
        <?php foreach($cart_products as $key => $cart): ?>
            <?php if(isset($cart) && count($cart)): ?>
                <?php foreach($cart as $key => $value): ?>
                    <?php $productData = $value['productData'] ?? [] ?>
                    <?php $productOptions = $value['productOptions'] ?? [] ?>
                    <li class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-3">
                            <a target="_blank" href="<?= site_url('products/details/'.($productData['id'] ?? 0)) ?>">
                                <?php if(isset($productData['image']) && !empty($productData['image']) && file_exists($productData['image'])): ?>
                                    <img class="img-fluid" src="<?= base_url($productData['image']) ?>" alt="...">
                                <?php else: ?>
                                    <img class="img-fluid" src="<?= base_url('assets/website/images/default-image.png') ?>" alt="...">
                                <?php endif; ?>
                            </a>
                        </div>
                        <div class="col d-flex align-items-center">
                            <div class="cart_single_caption pl-2">
                                <h4 class="product_title fs-md ft-medium mb-1 lh-1">
                                    <?= ($productData['product_name'] ?? '') ?>
                                </h4>

                                <p class="mb-1 lh-1">
                                    <span class="text-dark"><b>Qty:</b> <?= ($productData['quantity'] ?? 0) ?> X $<?= number_format(($productData['price'] ?? 0), 2) ?></span>
                                </p>

                                <?php if($productOptions && count($productOptions)): ?>
                                    <?php foreach($productOptions as $keyO => $keyV): ?>
                                        <?php if(preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $keyV)): ?>
                                            <p class="mb-1 lh-1">
                                                <span class="text-dark"><b><?= $keyO ?>:</b> <i class="fas fa-square" style="color: <?= $keyV ?> "></i></span>
                                            </p>
                                        <?php else: ?>
                                            <p class="mb-1 lh-1">
                                                <span class="text-dark"><b><?= $keyO ?>:</b> <?= $keyV ?></span>
                                            </p>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                                <h4 class="fs-md ft-medium mb-3 lh-1">
                                    $ <?= number_format((($productData['price'] ?? 0) * ($productData['quantity'] ?? 0)), 2) ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                </li>
                <?php
                $subTotal = ($subTotal+(($productData['price'] ?? 0) * ($productData['quantity'] ?? 0)));
                ?>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>
<div class="card mb-4 gray">
    <div class="card-body">
        <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">
            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                <span>Subtotal</span> 
                <span class="ml-auto text-dark ft-medium">$<?= number_format($subTotal, 2) ?></span>
            </li>
            <?php $shippingCost = 50; ?>
            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                <span>Shipping</span> 
                <span class="ml-auto text-dark ft-medium">$<?= number_format($shippingCost, 2) ?></span>
            </li>
            <?php $subTotal += $shippingCost; ?>
            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                <span>Total</span> <span class="ml-auto text-dark ft-medium">
                    $<?= number_format($subTotal, 2) ?>
                </span>
            </li>
            <!-- <li class="list-group-item fs-sm text-center">
                Shipping cost calculated at Checkout *
            </li> -->
        </ul>
    </div>
</div>
