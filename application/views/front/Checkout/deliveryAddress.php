<h5 class="mb-2 ft-medium">Delivery Address</h5>
<div class="row mb-4">
    <div class="col-12 col-lg-12 col-xl-12 col-md-12">
        <div class="panel-group" id="payaccordion">
            <div class="accordion">
                <?php if(!empty($user_addresses)): ?>
                    <?php foreach($user_addresses as $key => $address): ?>
                        <article class="panel panel-default border">
                            <input id="address_<?php echo ($address['id'] ?? 0); ?>" <?php echo ($key == 1) ? 'checked' : '' ?> type="radio" name="address_id" value="<?php echo ($address['id'] ?? 0); ?>">
                            <label class="article-lable" for="address_<?php echo ($address['id'] ?? 0); ?>">
                                <h5><?php echo ($address['title'] ?? ''); ?></h5>
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
                    <input id="address_new" type="radio" name="address_id" value="0">
                    <label class="article-lable" for="address_new">
                        <h5>Add a New Address</h5>
                    </label>
                    <div id="address_new" class="panel-collapse collapse show" aria-labelledby="pay" data-parent="#payaccordion">
                        <div class="panel-body">
                            <?php $this->load->view('front/myAccount/address/form') ?>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>
