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
                    <h1>Order Cancellation</h1>
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
                <p>I hope this message finds you well.</p>
                <p>I am writing to confirm that your order with us, bearing the order number #<?php echo $orderData['id'] ?? 0 ?>, has been successfully canceled as per your request.</p>
                <p>We understand that circumstances may change, and we strive to accommodate your needs to the best of our ability. Your order has been canceled, and any associated charges have been refunded to your original payment method.</p>
                <p>Thank you for your understanding and cooperation in this matter. We value your business and hope to have the opportunity to serve you again in the future.</p>
                <p>Thank you once again for choosing Ecommerce.</p>
                <p>Best Regards,<br>Ecommerce Team</p>
            </div>
        </div>
    </div>
</body>
</html>
