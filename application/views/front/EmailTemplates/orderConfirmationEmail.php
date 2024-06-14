<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        /* Add your custom CSS styles here */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .color-square {
            display: inline-block;
            width: 10px; /* adjust size as needed */
            height: 10px; /* adjust size as needed */
            margin-right: 4px; /* adjust spacing as needed */
        }
    </style>
</head>
<body>
<div style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
        <div style="width:100%;padding:20px 0">
            <div style="border-bottom:1px solid #eee">
                <a href="" style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">Ecommerce</a>
            </div>
            <div class="container">
                <div class="header">
                    <h1>Order Confirmation</h1>
                </div>
                <?php
                    if(isset($userData['first_name']) && isset($userData['last_name'])){
                        $userName = $userData['first_name'] .' '. $userData['last_name'];
                    } else {
                        $address = json_decode(($orderData['address_info'] ?? ''), true);
                        $userName = ($address['first_name'] ?? '') .' '. ($address['last_name'] ?? '');
                    }
                ?>
                <p>Dear <?php echo $userName ?? '' ?>,</p>
                <p>Thank you for shopping with Ecommerce! We are thrilled to confirm that your order has been successfully placed. Below are the details of your purchase:</p>
                <div class='order-data' style="font-family: Arial, sans-serif; line-height: 1.6;">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <th style="padding: 8px; border: 1px solid #dddddd;">Order#</th>
                                    <th style="padding: 8px; border: 1px solid #dddddd;">Customer Name</th>
                                    <th style="padding: 8px; border: 1px solid #dddddd;">Phone</th>
                                    <th style="padding: 8px; border: 1px solid #dddddd;">Date Ordered</th>
                                </tr>
                                <tr>
                                    <?php
                                        if(isset($userData['first_name']) && isset($userData['last_name'])){
                                            $userName = $userData['first_name'] .' '. $userData['last_name'] .'<br>('. ($userData['email'] ?? '') .')';
                                            $phone    = $userData['phone'] ?? '';
                                        } else {
                                            $address = json_decode(($orderData['address_info'] ?? ''), true);
                                            $userName = ($address['first_name'] ?? '') .' '. ($address['last_name'] ?? '') .' '. (isset($address['email']) ? ('<br>(' . $address['email'] . ')') : '');
                                            $phone    = $address['mobile_phone'] ?? '';
                                        }
                                    ?>
                                    <td width='10%' style="padding: 8px; border: 1px solid #dddddd;">#<?php echo ($orderData['id'] ?? 0) ?></td>
                                    <td width='40%' style="padding: 8px; border: 1px solid #dddddd;"><?php echo $userName; ?> </td>
                                    <td width='15%' style="padding: 8px; border: 1px solid #dddddd;"><?php echo $phone; ?> </td>
                                    <td width='25%' style="padding: 8px; border: 1px solid #dddddd;"><?php echo (date('Y-m-d H:i' ,strtotime($orderData['created_at'] ?? 0))) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row" style="margin: 0; padding: 0; margin-top:20px">
                    <div class="col-md-12" style="margin: 0; padding: 0;">
                        <table class="table table-bordered" style="width: 100%; border-collapse: collapse; margin: 0; padding: 0;">
                            <thead>
                                <tr>
                                    <th style="padding: 8px; border: 1px solid #ddd; text-align:left;">Product</th>
                                    <th style="padding: 8px; border: 1px solid #ddd; text-align:left;">SKU</th>
                                    <th style="padding: 8px; border: 1px solid #ddd; text-align:right;">Quantity</th>
                                    <th style="padding: 8px; border: 1px solid #ddd; text-align:right;">Unit Price</th>
                                    <th style="padding: 8px; border: 1px solid #ddd; text-align:right;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($orderData['items']) && count($orderData['items'])): ?>
                                    <?php foreach ($orderData['items'] as $item): ?>
                                        <tr>
                                            <td style="padding: 8px; border: 1px solid #ddd;">
                                                <div class="main-div d-flex">
                                                    <div class="image-div"> 
                                                        <?php if(isset($item['product']['image']) && file_exists($item['product']['image'])):?>
                                                            <!-- <img src="<?=  base_url($item['product']['image']) ?>" alt="..." width="50px" style="max-width: 100%; height: auto;"> -->
                                                            <img src="https://gorentonline.com/images/logo.png" alt="..." width="50px" style="max-width: 100%; height: auto;">
                                                        <?php else: ?>
                                                            <img src="<?= base_url('images/default-image.png') ?>" alt="..." width="50px" style="max-width: 100%; height: auto;">
                                                        <?php endif ?>
                                                    </div>

                                                    <div class="info-div pl-3">
                                                        <?php echo ($item['product_name'] ?? '') ?>
                                                        <?php if(isset($item['options']) && count($item['options'])): ?>
                                                            <?php foreach ($item['options'] as $option): ?>
                                                                <br>
                                                                    <small><b><?php echo $option['name'] ?? '' ?> : </b>
                                                                    <?php
                                                                    if (preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', ($option['value'] ?? ''))) {
                                                                        echo '<span class="color-square" style="background-color: '.($option['value'] ?? '').'"></span>';
                                                                    } else {
                                                                        echo ($option['value'] ?? '');
                                                                    }
                                                                    ?>
                                                                </small>
                                                            <?php endforeach ?>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                            </td>   
                                            <td style="padding: 8px; border: 1px solid #ddd; text-align:left;"><?php echo ($item['product_sku'] ?? '') ?></td>
                                            <td style="padding: 8px; border: 1px solid #ddd; text-align:right;"><?php echo ($item['product_qty'] ?? '') ?></td>
                                            <td style="padding: 8px; border: 1px solid #ddd; text-align:right;">$<?php echo number_format($item['product_price'] ?? 0, 2) ?></td>
                                            <td style="padding: 8px; border: 1px solid #ddd; text-align:right;">$<?php echo number_format($item['sub_total'] ?? 0, 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" style="padding: 8px; border: 1px solid #ddd;">No records found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style="padding: 8px; border: 1px solid #ddd; text-align:right;" colspan="4">Sub-Total</th>
                                    <td style="padding: 8px; border: 1px solid #ddd; text-align:right;" id="total_amount">$<?php echo number_format(($orderData['total_amount'] ?? 0), 2) ?></td>
                                </tr>
                                <tr>
                                    <th style="padding: 8px; border: 1px solid #ddd; text-align:right;" colspan="4">Tax(<?php echo ($orderData['tax_percentage'] ?? 0) ?>%)</th>
                                    <td style="padding: 8px; border: 1px solid #ddd; text-align:right;" id="total_amount">$<?php echo number_format(($orderData['tax_amount'] ?? 0), 2) ?></td>
                                </tr>
                                <tr>
                                    <th style="padding: 8px; border: 1px solid #ddd; text-align:right;" colspan="4">Shipping</th>
                                    <td style="padding: 8px; border: 1px solid #ddd; text-align:right;" id="shipping">$<?php echo number_format(($orderData['shipping_cost'] ?? 0), 2) ?></td>
                                </tr>
                                <tr>
                                    <?php $grandTotal = ($orderData['total_amount'] ?? 0) + ($orderData['shipping_cost'] ?? 0) + ($orderData['tax_amount'] ?? 0) ?>
                                    <th style="padding: 8px; border: 1px solid #ddd; text-align:right;" colspan="4">Total</th>
                                    <td style="padding: 8px; border: 1px solid #ddd; text-align:right;" id="grand_total">$<?php echo number_format($grandTotal, 2) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                        
                        <table class="table table-bordered" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                            <tbody>
                                <tr>
                                    <th style="padding: 8px; border: 1px solid #ddd; text-align:left;">Billing Address</th>
                                    <th style="padding: 8px; border: 1px solid #ddd; text-align:left;">Shipping Address</th>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; border: 1px solid #ddd; text-align:left;">
                                        <?php
                                            $addressArray = [];
                                            if(isset($orderData['address_info'])){
                                                $addressArray = json_decode($orderData['address_info'], true);
                                            }
                                        ?>

                                        <p style="margin: 0;">
                                            <?php if(isset($addressArray['first_name'])): ?>
                                                <?php echo $addressArray['first_name'] ?>
                                            <?php endif ?>

                                            <?php if(isset($addressArray['last_name'])): ?>
                                                <?php echo $addressArray['last_name'] ?>
                                            <?php endif ?>
                                        </p>

                                        <p style="margin: 0;">
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
                                    <td style="padding: 8px; border: 1px solid #ddd; text-align:left;">
                                        <?php
                                            $shippingAddressArray = [];
                                            if(isset($orderData['shipping_address_info'])){
                                                $shippingAddressArray = json_decode($orderData['shipping_address_info'], true);
                                            }
                                        ?>

                                        <p style="margin: 0;">
                                            <?php if(isset($shippingAddressArray['first_name'])): ?>
                                                <?php echo $shippingAddressArray['first_name'] ?>
                                            <?php endif ?>

                                            <?php if(isset($shippingAddressArray['last_name'])): ?>
                                                <?php echo $shippingAddressArray['last_name'] ?>
                                            <?php endif ?>
                                        </p>

                                        <p style="margin: 0;">
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

                        <table class="table table-bordered" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                            <tbody>
                                <tr>
                                    <th style="padding: 8px; border: 1px solid #ddd;  text-align:left;">Comment</th>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; border: 1px solid #ddd;  text-align:left;"><?php echo ((isset($orderData['notes']) && $orderData['notes']) ? $orderData['notes'] : '-') ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                            <tbody>
                                <tr>
                                    <th style="padding: 8px; border: 1px solid #ddd;  text-align:left;">Payment Method</th>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; border: 1px solid #ddd;  text-align:left;"><?php echo ($cardData ?? '') ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <p>Thank you once again for choosing Ecommerce. We appreciate your business!</p>
            <p>Best Regards,<br>Ecommerce Team</p>
        </div>
    </div>
</body>
</html>
