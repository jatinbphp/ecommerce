<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Forgot Password Email</title>
        <style>
        body {
        font-family: Arial, sans-serif;
        background-color: lightgrey;
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
        a {
        color: black;
        text-decoration: none;
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
            <img src='<?php echo base_url("images/logo.png"); ?>' class='company-logo mx-auto d-block' alt='Company Logo'>
        </header>
    <main>
        <p>Dear User,</p>
        <p>We received a request to reset your password.</p>
        <p>To proceed with resetting your password, please click the following link:</p>
        <p><a href='<?php echo $reset_link; ?>'>Reset Password</a></p>
        <p>If you didn't initiate this request, you can safely ignore this email.</p>
        <p>Thank you!</p>
    </main>
    </body>
</html>