<div class='order-data'>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Order ID</th>
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
                                $userName = ($address['first_name'] ?? '') .' '. ($address['last_name'] ?? '');
                                $phone    = $address['mobile_phone'] ?? '';
                            }
                        ?>
                        <td>#<?php echo ($orderData['id'] ?? 0) ?></td>
                        <td><?php echo $userName; ?> </td>
                        <td><?php echo $phone; ?> </td>
                        <td><?php echo ($orderData['created_at'] ?? '') ?></td>
                        <td><?php echo ($status[($orderData['status'] ?? '')] ?? '') ?></td>
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
                                            <?php echo ($item['product']['product_name'] ?? '') ?>
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
                        <td class="text-right" id="grand_total">$<?php echo number_format(($orderData['total_amount'] ?? 0), 2) ?></td>
                    </tr>
                    <tr>
                        <th class="text-right" colspan="4">Total</th>
                        <td class="text-right" id="grand_total">$<?php echo number_format(($orderData['total_amount'] ?? 0), 2) ?></td>
                    </tr>
                </tfoot>
            </table>
        
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Address</th>
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

                                <?php if (isset($addressArray['company'])): ?>
                                    <br><?php echo $addressArray['company'] ?>
                                <?php endif ?>

                                <?php if (isset($addressArray['address_line1'])): ?>
                                    <br><?php echo $addressArray['address_line1'] ?>,
                                <?php endif ?>


                                <?php if (isset($addressArray['address_line2'])): ?>
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
                            <?php echo ($orderData['notes'] ?? '') ?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Delivery Method</th>
                    </tr>
                    <tr>
                        <td>
                            <?php echo ($orderData['delivey_method'] ?? '') ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>