<div id="main-wrapper">
    <div class="gray py-3">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url(''); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url('profile-info'); ?>">My Account</a></li>
                            <li class="breadcrumb-item"><a href="#"><?php echo $title; ?></a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <section class="middle">
        <div class="container">
            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php elseif($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>
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
                                    <td>INV-<?php echo date('Y', strtotime($order->created_at)); ?>-<?php echo $order->id; ?></td>
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
                                                    <?php
                                                    
                                                    if (!empty($item->product_id)) {
                                                      
                                                        $product_images = $this->ProductImage_model->getImagesByProductId($item->product_id);
                                                        
                                                       
                                                        if (!empty($product_images)) {
                                                         
                                                            echo '<img src="' . base_url($product_images[0]->image) . '" alt="Product Image" width="50px">';
                                                        } else {
                                                          
                                                            echo '<img src="' . base_url('path/to/default-image.jpg') . '" alt="Default Image" width="50px">';
                                                        }
                                                    } else {
                                                   
                                                        echo '<img src="' . base_url('path/to/default-image.jpg') . '" alt="Default Image" width="50px">';
                                                    }
                                                    ?>
                                                </div>
                                                <div class="single_capt_right">
                                                  
                                                    <h4 class="product_title fs-sm ft-medium mb-1 lh-1">
                                                        <?php echo $item->product_name; ?>
                                                    </h4>
                                                  
                                                </div>
                                            </div>
                                        </td>

                                            <!-- Display SKU, Quantity, Unit Price, and Total -->
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
                                    <td colspan="4" class="text-right"><strong>Total</strong></td>
                                    <td class="text-right">$<?php echo number_format($order->total_amount, 2); ?></td>
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
