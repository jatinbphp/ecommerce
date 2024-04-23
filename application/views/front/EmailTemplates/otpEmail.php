<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>OTP Email</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }
            header {
                background-color: lightgrey;
                color: white;
                padding: 20px;
                text-align: center;
            }
            main {
                padding: 20px;
            }
            p {
                margin-bottom: 10px;
            }
            strong {
                color: black;
            }
            .logo {
                display: block;
                margin: 0 auto;
                max-width: 200px;
            }
        </style>
    </head>
    <body>
        <header>
            <img src="<?php echo base_url('images/logo.png'); ?>" class='company-logo mx-auto d-block' alt='Company Logo'>
        </header>
        <main>
            <p>Dear User,</p>
            <p>Your One-Time Password (OTP) is: <strong><?php echo $otpCode; ?></strong></p>
            <p>Please use this OTP to complete your verification process.</p>
            <p>If you didn't request this OTP, please ignore this email.</p>
            <p>Thank you!</p>
        </main>
    </body>
</html>