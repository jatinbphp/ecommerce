<div class='order-data'>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Order#</th>
                        <th>Customer Name</th>
                        <th>Phone</th>
                        <th>Date Ordered</th>
                        <th>Status</th>
                    </tr>
                    <tr>
                        <?php
                            if(isset($userData['first_name']) && isset($userData['last_name'])){
                                $userName = $userData['first_name'] .' '. $userData['last_name'] .'( '. ($userData['email'] ?? '') .' )';
                                $phone    = $userData['phone'] ?? '';
                            } else {
                                $address = json_decode(($orderData['address_info'] ?? ''), true);
                				$userName = ($address['first_name'] ?? '') .' '. ($address['last_name'] ?? '') .' '. (isset($address['email']) ? ('(' . $address['email'] . ')') : '');
                                $phone    = $address['mobile_phone'] ?? '';
                            }
                        ?>
                        <td width='10%'>#<?php echo ($orderData['id'] ?? 0) ?></td>
                        <td width='40%'><?php echo $userName; ?> </td>
                        <td width='15%'><?php echo $phone; ?> </td>
                        <td width='25%'><?php echo ($orderData['created_at'] ?? '') ?></td>
                        <td width='10%'><?php echo ($status[($orderData['status'] ?? '')] ?? '') ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Quantity</th>
                        <th class="text-right">Unit Price</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($orderData['items']) && count($orderData['items'])): ?>
                        <?php foreach ($orderData['items'] as $item): ?>
                            <tr>
                                <td>
                                    <div class="main-div d-flex">
                                        <div class="image-div"> 
                                            <?php if(isset($item['product']['image']) && file_exists($item['product']['image'])):?>
                                                <img src="<?= base_url($item['product']['image']) ?>" alt="..." width="50px">
                                            <?php else: ?>
                                                <img src="<?= base_url('images/default-image.png') ?>" alt="..." width="50px">
                                            <?php endif ?>
                                        </div>

                                        <div class="info-div pl-3">
                                            <?php echo ($item['product_name'] ?? '') ?>
                                            <?php if(isset($item['options']) && count($item['options'])): ?>
                                                <?php foreach ($item['options'] as $option): ?>
                                                    </br><small><b><?php echo $option['name'] ?? '' ?> : </b><?php echo preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', ($option['value'] ?? '')) ? '<i class="fas fa-square" style="color: '.($option['value'] ?? '').'"></i>' : ($option['value'] ?? ''); ?></small>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </td>   
                                <td><?php echo ($item['product_sku'] ?? '') ?></td>
                                <td><?php echo ($item['product_qty'] ?? '') ?></td>
                                <td class="text-right">$<?php echo number_format($item['product_price'] ?? 0, 2) ?></td>
                                <td class="text-right">$<?php echo number_format($item['sub_total'] ?? 0, 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-right" colspan="4">Sub-Total</th>
                        <td class="text-right" id="total_amount">$<?php echo number_format(($orderData['total_amount'] ?? 0), 2) ?></td>
                    </tr>
                    <tr>
                        <th class="text-right" colspan="4">Tax(<?php echo ($orderData['tax_percentage'] ?? 0) ?>%)</th>
                        <td class="text-right" id="total_amount">$<?php echo number_format(($orderData['tax_amount'] ?? 0), 2) ?></td>
                    </tr>
                    <tr>
                        <th class="text-right" colspan="4">Shipping</th>
                        <td class="text-right" id="shipping">$<?php echo number_format(($orderData['shipping_cost'] ?? 0), 2) ?></td>
                    </tr>
                    <tr>
                        <?php $grandTotal = ($orderData['total_amount'] ?? 0) + ($orderData['shipping_cost'] ?? 0) + ($orderData['tax_amount'] ?? 0) ?>
                        <th class="text-right" colspan="4">Total</th>
                        <td class="text-right" id="grand_total">$<?php echo number_format($grandTotal, 2) ?></td>
                    </tr>
                </tfoot>
            </table>
                        
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th width='50%'>Transaction Id</th>
                        <th width='50%'>Refund Id</th>
                    </tr>
                    <tr>
                        <td>
                            <h6 class='ft-medium'><?php echo ((isset($orderData['payment_intent_id']) && $orderData['payment_intent_id']) ? $orderData['payment_intent_id'] : '-') ; ?></h6>
                        </td>
                        <td>
                            <h6 class='ft-medium'><?php echo ((isset($orderData['payment_refund_id']) && $orderData['payment_refund_id']) ? $orderData['payment_refund_id'] : '-') ; ?></h6>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th width=50%>Billing Address</th>
                        <th width=50%>Shipping Address</th>
                    </tr>
                    <tr>
                        <td>
                            <?php
                                $addressArray = [];
                                if(isset($orderData['address_info'])){
                                    $addressArray = json_decode($orderData['address_info'], true);
                                }
                            ?>

                            <h5 class="ft-medium mb-1">
                                <?php if(isset($addressArray['first_name'])): ?>
                                    <?php echo $addressArray['first_name'] ?>
                                <?php endif ?>

                                <?php if(isset($addressArray['last_name'])): ?>
                                    <?php echo $addressArray['last_name'] ?>
                                <?php endif ?>
                            </h5>

                            <p>
                                <?php if (isset($addressArray['title'])): ?>
                                    <br><b><?php echo $addressArray['title'] ?></b>
                                <?php endif ?>

                                <?php if (isset($addressArray['company']) && $addressArray['company']): ?>
                                    <br><?php echo $addressArray['company'] ?>
                                <?php endif ?>

                                <?php if (isset($addressArray['address_line1'])): ?>
                                    <br><?php echo $addressArray['address_line1'] ?>,
                                <?php endif ?>

                                <?php if (isset($addressArray['address_line2']) && $addressArray['address_line2']): ?>
                                    <br><?php echo $addressArray['address_line2'] ?>,
                                <?php endif ?>

                                <br>
                                <?php if (isset($addressArray['pincode'])) : ?>
                                    <?php echo $addressArray['pincode']; ?> -
                                <?php endif; ?>
                                <?php if (isset($addressArray['city'])) : ?>
                                    <?php echo $addressArray['city']; ?>,
                                <?php endif; ?>
                                <?php if (isset($addressArray['state'])) : ?>
                                    <?php echo $addressArray['state']; ?>,
                                <?php endif; ?>
                                <?php if (isset($addressArray['country'])) : ?>
                                    <?php echo $addressArray['country']; ?>
                                <?php endif; ?>
                            </p>
                        </td>
                        <td>
                            <?php
                                $shippingAddressArray = [];
                                if(isset($orderData['shipping_address_info'])){
                                    $shippingAddressArray = json_decode($orderData['shipping_address_info'], true);
                                }
                            ?>

                            <h5 class="ft-medium mb-1">
                                <?php if(isset($shippingAddressArray['first_name'])): ?>
                                    <?php echo $shippingAddressArray['first_name'] ?>
                                <?php endif ?>

                                <?php if(isset($shippingAddressArray['last_name'])): ?>
                                    <?php echo $shippingAddressArray['last_name'] ?>
                                <?php endif ?>
                            </h5>

                            <p>
                                <?php if (isset($shippingAddressArray['title'])): ?>
                                    <br><b><?php echo $shippingAddressArray['title'] ?></b>
                                <?php endif ?>

                                <?php if (isset($shippingAddressArray['company']) && $shippingAddressArray['company']): ?>
                                    <br><?php echo $shippingAddressArray['company'] ?>
                                <?php endif ?>

                                <?php if (isset($shippingAddressArray['address_line1'])): ?>
                                    <br><?php echo $shippingAddressArray['address_line1'] ?>,
                                <?php endif ?>

                                <?php if (isset($shippingAddressArray['address_line2']) && $shippingAddressArray['address_line2']): ?>
                                    <br><?php echo $shippingAddressArray['address_line2'] ?>,
                                <?php endif ?>

                                <br>
                                <?php if (isset($shippingAddressArray['pincode'])) : ?>
                                    <?php echo $shippingAddressArray['pincode']; ?> -
                                <?php endif; ?>
                                <?php if (isset($shippingAddressArray['city'])) : ?>
                                    <?php echo $shippingAddressArray['city']; ?>,
                                <?php endif; ?>
                                <?php if (isset($shippingAddressArray['state'])) : ?>
                                    <?php echo $shippingAddressArray['state']; ?>,
                                <?php endif; ?>
                                <?php if (isset($shippingAddressArray['country'])) : ?>
                                    <?php echo $shippingAddressArray['country']; ?>
                                <?php endif; ?>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Comment</th>
                    </tr>
                    <tr>
                        <td>
                            <?php echo ((isset($orderData['notes']) && $orderData['notes']) ? $orderData['notes'] : '-') ?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Payment Method</th>
                    </tr>
                    <tr>
                        <td>
                            <?php echo isset($orderData['card_brand']) ? $orderData['card_brand'] : '' ?> - <?php echo isset($orderData['card_four']) ? $orderData['card_four'] : '' ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
