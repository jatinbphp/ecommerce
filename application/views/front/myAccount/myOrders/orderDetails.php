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
                                    <?php if($order->status == \Order_model::STATUS_TYPE_PENDING): ?>
                                        <?php $class = 'ft-medium small text-primary bg-light-primary rounded px-3 py-1'; ?>
                                    <?php elseif($order->status == \Order_model::STATUS_TYPE_CANCEL): ?>
                                        <?php $class = 'ft-medium small text-danger bg-light-danger rounded px-3 py-1'; ?>
                                    <?php else: ?>
                                        <?php $class = 'ft-medium small text-success bg-light-success rounded px-3 py-1'; ?>
                                    <?php endif; ?>
                                    <td><span class="<?php echo $class; ?>"><?php echo $order->status; ?></span></td>
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
                                    <td colspan="4" class="text-right"><strong>Tax(<?php echo ($order->tax_percentage ?? 0) ?>%)</strong></td>
                                    <td class="text-right">$<?php echo number_format($order->tax_amount, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Shipping</strong></td>
                                    <td class="text-right">$<?php echo number_format($order->shipping_cost, 2); ?></td>
                                </tr>
                                <?php $totalAmount = ($order->total_amount + $order->shipping_cost + $order->tax_amount); ?>
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
                                    <th width='50%'>Transaction Id</th>
                                    <th width='50%'>Refund Id</th>
                                </tr>
                                <tr>
                                    <td>
                                        <h6 class='ft-medium'><?php echo ($order->payment_intent_id ? $order->payment_intent_id : '-') ; ?></h6>
                                    </td>
                                    <td>
                                        <h6 class='ft-medium'><?php echo ($order->payment_refund_id ? $order->payment_refund_id : '-') ; ?></h6>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive mb-4">
                        <table class="table m-0">
                            <tbody>
                                <tr>
                                    <th width='50%'>Billing Address</th>
                                    <th width='50%'>Shipping Address</th>
                                </tr>
                                <tr>
                                    <td>
                                        <?php
                                            $addressArray = [];
                                            if(isset($order->address_info)){
                                                $addressArray = json_decode($order->address_info, true);
                                            }
                                        ?>
                                        <h5 class="ft-medium mb-1">
                                            <?php echo isset($addressArray['first_name']) ? $addressArray['first_name'] : ''; ?>
                                            <?php echo isset($addressArray['last_name']) ? $addressArray['last_name'] : ''; ?>
                                        </h5>
                                        <p>
                                            <?php echo isset($addressArray['title']) ? '<br><b>'.$addressArray['title'].'</b>' : '' ?>
                                            <?php echo isset($addressArray['company']) ? '<br>'.$addressArray['company'] : '' ?>
                                            <?php echo isset($addressArray['address_line1']) ? '<br>'.$addressArray['address_line1']. ',' : ''?>
                                            <?php echo (isset($addressArray['address_line2']) && $addressArray['address_line2']) ? '<br>' . $addressArray['address_line2']. ',' : ''?>
                                            <?php if (!empty($addressArray['city']) || !empty($addressArray['state']) || !empty($addressArray['country']) || !empty($addressArray['pincode'])): ?>
                                                <br>
                                                <?php echo isset($addressArray['pincode']) ? $addressArray['pincode']. ' - ' : ''; ?>
                                                <?php echo isset($addressArray['city']) ? $addressArray['city'] . ', ' : ''; ?>
                                                <?php echo isset($addressArray['state']) ? $addressArray['state'] . ', ' : ''; ?>
                                                <?php echo isset($addressArray['country']) ? $addressArray['country'] . ', ' : ''; ?>
                                            <?php endif; ?>
                                        </p>
                                    </td>
                                    <td>
                                        <?php
                                            $shippingAddressArray = [];
                                            if(isset($order->shipping_address_info)){
                                                $shippingAddressArray = json_decode($order->shipping_address_info, true);
                                            }
                                        ?>
                                        <h5 class="ft-medium mb-1">
                                            <?php echo isset($shippingAddressArray['first_name']) ? $shippingAddressArray['first_name'] : ''; ?>
                                            <?php echo isset($shippingAddressArray['last_name']) ? $shippingAddressArray['last_name'] : ''; ?>
                                        </h5>
                                        <p>
                                            <?php echo isset($shippingAddressArray['title']) ? '<br><b>'.$shippingAddressArray['title'].'</b>' : '' ?>
                                            <?php echo isset($shippingAddressArray['company']) ? '<br>'.$shippingAddressArray['company'] : '' ?>
                                            <?php echo isset($shippingAddressArray['address_line1']) ? '<br>'.$shippingAddressArray['address_line1']. ',' : ''?>
                                            <?php echo (isset($shippingAddressArray['address_line2']) && $shippingAddressArray['address_line2']) ? '<br>' . $shippingAddressArray['address_line2']. ',' : ''?>
                                            <?php if (!empty($shippingAddressArray['city']) || !empty($shippingAddressArray['state']) || !empty($shippingAddressArray['country']) || !empty($shippingAddressArray['pincode'])): ?>
                                                <br>
                                                <?php echo isset($shippingAddressArray['pincode']) ? $shippingAddressArray['pincode']. ' - ' : ''; ?>
                                                <?php echo isset($shippingAddressArray['city']) ? $shippingAddressArray['city'] . ', ' : ''; ?>
                                                <?php echo isset($shippingAddressArray['state']) ? $shippingAddressArray['state'] . ', ' : ''; ?>
                                                <?php echo isset($shippingAddressArray['country']) ? $shippingAddressArray['country'] . ', ' : ''; ?>
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
                                    <th>Payment Method</th>
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
