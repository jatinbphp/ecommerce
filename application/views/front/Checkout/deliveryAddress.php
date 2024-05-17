<h5 class="mb-2 ft-medium">Billing Address</h5>
<div class="row mb-4">
    <div class="col-12 col-lg-12 col-xl-12 col-md-12">
        <div class="panel-group" id="payaccordion">
            <div class="accordion">
                <?php if(!empty($user_billing_addresses)): ?>
                    <?php foreach($user_billing_addresses as $key => $address): ?>
                        <article class="panel panel-default border">
                            <input id="address_<?php echo ($address['id'] ?? 0); ?>" class='addresses-radio' <?php echo ($key == 1) ? 'checked' : '' ?> type="radio" name="address_id" value="<?php echo ($address['id'] ?? 0); ?>">
                            <label class="article-lable" for="address_<?php echo ($address['id'] ?? 0); ?>">
                                <h5><?php echo (isset($address['title']) && $address['title'] ? $address['title'] : 'Address'); ?></h5>
                            </label>
                            <div id="address_<?php echo ($address['id'] ?? ''); ?>" class="panel-collapse collapse show" aria-labelledby="pay" data-parent="#payaccordion">
                                <div class="panel-body">
                                    <h5 class="ft-medium mb-1">
                                        <span class='d-none' id='first_name_<?php echo ($address['id'] ?? '') ?>'><?php echo ($address['first_name'] ?? '')?></span>
                                        <span class='d-none' id='last_name_<?php echo ($address['id'] ?? '') ?>'><?php echo ($address['last_name'] ?? '')?></span>
                                        <?php echo ($address['first_name'] ?? '') . ' ' . ($address['last_name'] ?? ''); ?>
                                    </h5>
                                    <p>
                                        <?php if (isset($address['title']) && !empty($address['title'])): ?>
                                            <?php echo $address['title']; ?>
                                        <?php endif; ?>

                                        <?php if (isset($address['company']) && !empty($address['company'])): ?>
                                            <br><?php echo $address['company']; ?>
                                        <?php endif; ?>

                                        <?php if (isset($address['address_line1']) && !empty($address['address_line1'])): ?>
                                            <br><span id='address_line1_<?php echo $address['id'] ?? 0 ?>'><?php echo $address['address_line1']; ?></span>,
                                        <?php endif; ?>

                                        <?php if (isset($address['address_line2']) && !empty($address['address_line2'])): ?>
                                            <br><span id='address_line2_<?php echo $address['id'] ?? 0 ?>'><?php echo $address['address_line2']; ?></span>,
                                        <?php endif; ?>

                                        <?php if ((isset($address['city']) && !empty($address['city'])) || (isset($address['state']) && !empty($address['state'])) || (isset($address['country']) && !empty($address['country'])) || (isset($address['pincode']) && !empty($address['pincode']))): ?>
                                            <br>
                                            <?php if (isset($address['pincode']) && !empty($address['pincode'])): ?> <span id='pincode_<?php echo $address['id'] ?? 0 ?>'><?php echo $address['pincode']; ?></span> - <?php endif; ?>
                                            <?php if (isset($address['city']) && !empty($address['city'])): ?> <span id='city_<?php echo $address['id'] ?? 0 ?>'><?php echo $address['city']; ?></span>, <?php endif; ?>
                                            <?php if (isset($address['state']) && !empty($address['state'])): ?> <span id='state_<?php echo $address['id'] ?? 0 ?>'><?php echo $address['state']; ?></span>, <?php endif; ?>
                                            <?php if (isset($address['country']) && !empty($address['country'])): ?> <span id='country_<?php echo $address['id'] ?? 0 ?>'><?php echo $address['country']; ?></span> <?php endif; ?>
                                        <?php endif; ?>
                                    </p>
                                    <?php if(isset($address['mobile_phone']) && !empty($address['mobile_phone'])): ?>
                                        <p>
                                            <span class="text-dark ft-medium">Call:</span> 
                                            <a href="tel:<?php echo ($address['mobile_phone'] ?? ''); ?>"><span id='mobile_phone_<?php echo $address['id'] ?? 0 ?>'><?php echo ($address['mobile_phone'] ?? ''); ?></span></a><br>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>

                <article class="panel panel-default border">
                    <input id="address_new" class='addresses-radio' <?php echo (empty($user_billing_addresses) ? 'checked' : '') ?> type="radio" name="address_id" value="0">
                    <label class="article-lable" for="address_new">
                        <h5>Add Billing Address</h5>
                    </label>
                    <div id="address_new_div" class="panel-collapse collapse show" aria-labelledby="pay" data-parent="#payaccordion">
                        <div class="panel-body">
                            <?php $this->load->view('front/Checkout/billingAddress') ?>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>

<h5 class="mb-2 ft-medium">Shipping Address</h5>
<div class="row mb-4">
    <div class="col-12 col-lg-12 col-xl-12 col-md-12">
        <div class="panel-group" id="payaccordion">
            <div class="accordion">
                <?php if(!empty($user_shipping_addresses)): ?>
                    <?php foreach($user_shipping_addresses as $key => $address): ?>
                        <article class="panel panel-default border">
                            <input id="address_<?php echo ($address['id'] ?? 0); ?>" class='' <?php echo ($key == 1) ? 'checked' : '' ?> type="radio" name="shipping_address_id" value="<?php echo ($address['id'] ?? 0); ?>">
                            <label class="article-lable" for="address_<?php echo ($address['id'] ?? 0); ?>">
                                <h5><?php echo (isset($address['title']) && $address['title'] ? $address['title'] : 'Address'); ?></h5>
                            </label>
                            <div id="address_<?php echo ($address['id'] ?? ''); ?>" class="panel-collapse collapse show" aria-labelledby="pay" data-parent="#payaccordion">
                                <div class="panel-body">
                                    <h5 class="ft-medium mb-1">
                                        <?php echo ($address['first_name'] ?? '') . ' ' . ($address['last_name'] ?? ''); ?>
                                    </h5>
                                    <p>
                                        <?php if (isset($address['title']) && !empty($address['title'])): ?>
                                            <?php echo $address['title']; ?>
                                        <?php endif; ?>

                                        <?php if (isset($address['company']) && !empty($address['company'])): ?>
                                            <br><?php echo $address['company']; ?>
                                        <?php endif; ?>

                                        <?php if (isset($address['address_line1']) && !empty($address['address_line1'])): ?>
                                            <br><?php echo $address['address_line1']; ?>,
                                        <?php endif; ?>

                                        <?php if (isset($address['address_line2']) && !empty($address['address_line2'])): ?>
                                            <br><?php echo $address['address_line2']; ?>,
                                        <?php endif; ?>

                                        <?php if ((isset($address['city']) && !empty($address['city'])) || (isset($address['state']) && !empty($address['state'])) || (isset($address['country']) && !empty($address['country'])) || (isset($address['pincode']) && !empty($address['pincode']))): ?>
                                            <br>
                                            <?php if (isset($address['pincode']) && !empty($address['pincode'])): ?> <?php echo $address['pincode']; ?> - <?php endif; ?>
                                            <?php if (isset($address['city']) && !empty($address['city'])): ?> <?php echo $address['city']; ?>, <?php endif; ?>
                                            <?php if (isset($address['state']) && !empty($address['state'])): ?> <?php echo $address['state']; ?>, <?php endif; ?>
                                            <?php if (isset($address['country']) && !empty($address['country'])): ?> <?php echo $address['country']; ?> <?php endif; ?>
                                        <?php endif; ?>
                                    </p>
                                    <?php if(isset($address['mobile_phone']) && !empty($address['mobile_phone'])): ?>
                                        <p>
                                            <span class="text-dark ft-medium">Call:</span> 
                                            <a href="tel:<?php echo ($address['mobile_phone'] ?? ''); ?>"><?php echo ($address['mobile_phone'] ?? ''); ?></a><br>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>

                <article class="panel panel-default border">
                    <input id="shipping_address_new" class='' <?php echo (empty($user_shipping_addresses) ? 'checked' : '') ?> type="radio" name="shipping_address_id" value="0">
                    <label class="article-lable" for="shipping_address_new">
                        <h5>Add Shipping Address</h5>
                    </label>
                    <div id="shipping_address_new_div" class="panel-collapse collapse show" aria-labelledby="pay" data-parent="#payaccordion">
                        <div class="panel-body">
                            <?php $this->load->view('front/Checkout/shippingAddress') ?>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>
