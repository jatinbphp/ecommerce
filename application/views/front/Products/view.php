<?php if(isset($product) && !empty($product)): ?>
    <div class="quick_view_wrap">
        <div class="quick_view_thmb">
            <?php $images = explode(",", ($product['images'] ?? '')); ?>
            <?php if($images && count($images) > 1): ?>
                <div class="quick_view_slide">
                    <?php foreach($images as $imageKey => $imageValue): ?>
                        <div class="single_view_slide">
                            <?php if(file_exists($imageValue)): ?>
                                <img src="<?php echo base_url($imageValue)?>" class="img-fluid image-view-slider" id="image-<?= $imageKey ?>" alt="" />
                            <?php else: ?>
                                <img src="<?php echo base_url('images/default-image.png')?>" class="img-fluid image-view-slider" id="image-<?= $imageKey ?>" alt="" />
                            <?php endif; ?>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php else: ?>
                <div class="single_view_slide">
                    <?php $image = ($images[0] ?? '') ?>
                    <?php if(file_exists($image)): ?>
                        <img src="<?php echo base_url($image)?>" class="img-fluid image-view-slider" alt="" />
                    <?php else: ?>
                        <img src="<?php echo base_url('images/default-image.png')?>" class="img-fluid image-view-slider" alt="" />
                    <?php endif; ?>
                </div>
            <?php endif ?>
        </div>
        <div class="quick_view_capt">
            <div class="prd_details">
                <div class="prt_01 mb-1"><span class="text-light bg-info rounded px-2 py-1"><?= $product['category_name'] ?? "" ?></span></div>
                <div class="prt_02 mb-2">
                    <h2 class="ft-bold mb-1"><?= $product['product_name'] ?? "" ?></h2>
                    <div class="text-left">
                    <?php 
                        $productId = ($product['id'] ?? 0);
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
                        <div class="elis_rty">
                            <span class="ft-medium text-muted line-through fs-md mr-2">$<?= number_format(($product['price'] * 2), 2) ?></span>
                            <span class="ft-bold theme-cl fs-lg mr-2">$<?= number_format(($product['price']), 2) ?></span>
                            <span class="ft-regular text-success bg-light-success py-1 px-2 fs-sm"><?= $product['stock_status']['in_stock'] ?? "" ?></span>
                        </div> 
                    </div>
                </div>
                <div class="prt_03 mb-3">
                    <?= substr($product['description'], 0, 300) . (strlen($product['description']) > 300 ? '...' : '')?>
                </div>
                <?php echo form_open('cart/add-product-to-cart', ['method' => 'post', 'id' => 'addProductToCartFormDetails']); ?>
                <?php echo form_hidden('product_id', $product['id']); ?>
                <?php if(isset($product['options']) && !empty($product['options'])): ?>
                    <?php foreach($product['options'] as $option): ?>
                        <div class="prt_04">
                            <p class="d-flex align-items-center mb-0 text-dark ft-medium text-capitalize"><?= $option['option_name'] ?? "-" ?>:</p>
                            <div class="pb-0 pt-2">
                                <?php if(isset($option['option_type']) && $option['option_type'] == "select"): ?>
                                    <select id="<?= $option['id'] ?>" name="options[<?= ($option['id'] ?? '') ?>]" class="form-control" style="width:100px">
                                <?php endif ?>
                                <?php if(isset($option['option_values']) && !empty($option['option_values'])): ?>
                                    <?php foreach($option['option_values'] as $optionKey => $optionValue): ?>
                                        <?php if(isset($option['option_type']) && $option['option_type'] == "color"): ?>
                                            <div class="form-check form-option form-check-inline mb-1">
                                                <input class="form-check-input" <?= ($optionKey === 0) ? 'checked' : '' ?> type="radio" name="options[<?= ($option['id'] ?? '') ?>]" value="<?= $optionValue['id'] ?? null ?>" id="<?= $option['option_type'] ?>-<?= $optionValue['id'] ?? '' ?>">
                                                <label class="form-option-label rounded-circle" for="<?= $option['option_type'] ?>-<?= $optionValue['id'] ?? '' ?>">
                                                    <span class="form-option-color rounded-circle" style="background-color: <?= $optionValue['option_value'] ?? null ?>;"></span>
                                                </label>
                                            </div>
                                        <?php endif ?>
                                        <?php if(isset($option['option_type']) && $option['option_type'] == "select"): ?>
                                            <option value="<?= $optionValue['id'] ?? null ?>" <?= ($optionKey === 0) ? 'selected' : '' ?>><?= $optionValue['option_value'] ?></option>
                                        <?php endif ?>
                                        <?php if(isset($option['option_type']) && $option['option_type'] == "radio"): ?>
                                            <div class="form-check size-option form-option form-check-inline mb-2">
                                                <input class="form-check-input" type="radio" <?= ($optionKey === 0) ? 'checked' : '' ?> name="options[<?= ($option['id'] ?? '') ?>]" value="<?= $optionValue['id'] ?? null ?>" id="<?= $option['option_type'] ?>-<?= $optionValue['id'] ?? '' ?>">
                                                <label class="form-option-label" for="<?= $option['option_type'] ?>-<?= $optionValue['id'] ?? '' ?>"><?= $optionValue['option_value'] ?></label>
                                            </div>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                <?php endif ?>
                            <?php if(isset($option['option_type']) && $option['option_type'] == "select"): ?>
                                </select>
                            <?php endif ?>
                            </div>
                        </div>
                    <?php endforeach ?>
                <?php endif ?>

                <div class="prt_05 mb-4">
                    <div class="form-row mb-7">
                        <div class="col-12 col-lg-auto">
                            <!-- Quantity -->
                            <select name="quantity" class="mb-2 custom-select">
                                <?php if(isset($product['quantity']) && !empty($product['quantity'])): ?>
                                    <?php foreach($product['quantity'] as $key => $quantity): ?>
                                        <option value="<?= $quantity ?>" <?= $key == 0 ? "selected" : "" ?>><?= $quantity ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                        <div class="col-12 col-lg">
                            <!-- Submit -->
                            <button type="submit" class="btn btn-block custom-height bg-dark mb-2" id="add_to_cartproduct">
                                <i class="lni lni-shopping-basket mr-2"></i>Add to Cart 
                            </button>
                        </div>
                        <div class="col-12 col-lg-auto">
                            <!-- Wishlist -->
                            <button class="btn custom-height btn-default btn-block mb-2 text-dark snackbar-wishlist <?php echo (in_array(($product['id'] ?? ''), ($wishlistProductId ?? []))) ? 'active-wishlist' : ''; ?>" data-id="<?php echo ($product['id'] ?? 0) ?>" data-toggle="button">
                            <i class="lni lni-heart mr-2"></i>Wishlist
                            </button>
                        </div>

                    </div>
                </div>
                <?php echo form_close(); ?>
                <div class="prt_06">
                    <p class="mb-0 d-flex align-items-center">
                        <span class="mr-4">Share:</span>
                        <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted mr-2" href="#!">
                        <i class="fab fa-twitter position-absolute"></i>
                        </a>
                        <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted mr-2" href="#!">
                        <i class="fab fa-facebook-f position-absolute"></i>
                        </a>
                        <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted" href="#!">
                        <i class="fab fa-pinterest-p position-absolute"></i>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>
