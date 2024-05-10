<div id="main-wrapper">
    <?php $this->load->view('Breadcrumb',['current' => $title, 'middle' => ['my_account' => 'profile-info']]); ?>
    <section class="middle">
        <div class="container">
            <div class="row align-items-start justify-content-between">
                <?php $this->load->view('front/myAccount/common-file'); ?>
                <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                    <div class="table-responsive mb-4">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer Name</th>
                                    <th>Date Ordered</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#<?php echo $order->id; ?></td>
                                    <td><?php echo isset($user['first_name']) ? $user['first_name'] : ''; ?> (<?php echo isset($user['email']) ? $user['email'] : ''; ?>)</td>
                                    <td><?php echo $order->created_at; ?></td>
                                    <td><span class="ft-medium small text-primary bg-light-primary rounded px-3 py-1"><?php echo $order->status; ?></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive mb-4">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Product Information</th>
                                    <th>SKU</th>
                                    <th>Quantity</th>
                                    <th class="text-right">Unit Price</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($orderItems)): ?>
                                    <?php foreach ($orderItems as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="single_rev_caption d-flex align-items-start">
                                                    <div class="single_capt_left pr-2">
                                                        <?php if (!empty($item->product_id)): ?>
                                                            <?php $product_images = $this->ProductImage_model->getDetails($item->product_id); ?>
                                                            <?php if (!empty($product_images)): ?>
                                                                <?php $product_images = current($product_images); ?>
                                                                <?php $image = (isset($product_images['image']) && file_exists($product_images['image']) ? $product_images['image'] : 'images/default-image.png') ?>
                                                                <img class="card-img-top" src="<?php echo base_url($image); ?>" alt="Product Image" style="width:50px">
                                                            <?php else: ?>
                                                                <img src="<?php echo base_url('images/default-image.png'); ?>" alt="Banner Image" style="border: 1px solid #ccc;margin-top: 5px;padding: 20px;" width="50px" id="Product Image">
                                                            <?php endif ?>
                                                        <?php endif ?>
                                                    </div>
                                                    <div class="single_capt_right">
                                                        <h4 class="product_title fs-sm ft-medium mb-1 lh-1">
                                                            <?php echo $item->product_name; ?>
                                                        </h4>
                                                        <?php
                                                            $orderProductId = $item->id;
                                                            $optins =$returnArray = array_filter($orderAttributes, function($item) use($orderProductId) {
                                                                return $item->order_product_id == $orderProductId;
                                                            });
                                                        ?>
                                                        <?php if(!empty($optins)): ?>
                                                            <?php foreach ($optins as $optionData): ?>
                                                                <p class="m-0 mb-1 lh-1">
                                                                    <span class="text-dark medium"><?php echo ($optionData->name ?? '');?> : <?php echo preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', ($optionData->value ?? '')) ? '<i class="fas fa-square" style="color: '.($optionData->value ?? '').'"></i>' : ($optionData->value ?? ''); ?></span>
                                                                </p>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo $item->product_sku; ?></td>
                                            <td><?php echo $item->product_qty; ?></td>
                                            <td class="text-right">$<?php echo number_format($item->product_price, 2); ?></td>
                                            <td class="text-right">$<?php echo number_format($item->sub_total, 2); ?></td>
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
                                    <td colspan="4" class="text-right"><strong>Sub-Total</strong></td>
                                    <td class="text-right">$<?php echo number_format($order->total_amount, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Shipping</strong></td>
                                    <td class="text-right">$<?php echo number_format($order->shipping_cost, 2); ?></td>
                                </tr>
                                <?php $totalAmount = ($order->total_amount + $order->shipping_cost); ?>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Total</strong></td>
                                    <td class="text-right">$<?php echo number_format($totalAmount, 2); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="table-responsive mb-4">
                        <table class="table m-0">
                            <tbody>
                                <tr>
                                    <th>Address</th>
                                </tr>
                                <tr>
                                    <td>
                                        <h5 class="ft-medium mb-1">
                                            <?php echo isset($address['first_name']) ? $address['first_name'] : ''; ?>
                                            <?php echo isset($address['last_name']) ? $address['last_name'] : ''; ?>
                                        </h5>
                                        <p>
                                            <?php echo isset($address['title']) ? '<br><b>'.$address['title'].'</b>' : '' ?>
                                            <?php echo isset($address['company']) ? '<br>'.$address['company'] : '' ?>
                                            <?php echo isset($address['address_line1']) ? '<br>'.$address['address_line1']. ',' : ''?>
                                            <?php echo isset($address['address_line2']) ? '<br>' . $address['address_line2']. ',' : ''?>
                                            <?php if (!empty($address['city']) || !empty($address['state']) || !empty($address['country']) || !empty($address['pincode'])): ?>
                                                <br>
                                                <?php echo isset($address['pincode']) ? $address['pincode']. ' - ' : ''; ?>
                                                <?php echo isset($address['city']) ? $address['city'] . ', ' : ''; ?>
                                                <?php echo isset($address['state']) ? $address['state'] . ', ' : ''; ?>
                                                <?php echo isset($address['country']) ? $address['country'] . ', ' : ''; ?>
                                            <?php endif; ?>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive mb-4">
                        <table class="table m-0">
                            <tbody>
                                <tr>
                                    <th>Comment</th>
                                </tr>
                                <tr>
                                    <td><?php echo $order->notes; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive mb-4">
                        <table class="table m-0">
                            <tbody>
                                <tr>
                                    <th>Delivery Method</th>
                                </tr>
                                <tr>
                                    <td><?php echo $order->delivey_method; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#myorderlist").addClass('active');
    });
</script>
