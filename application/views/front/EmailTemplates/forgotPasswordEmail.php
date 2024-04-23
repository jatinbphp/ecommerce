<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Forgot Password Email</title>
    </head>
    <body>
        <div style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
            <div style="width:100%;padding:20px 0">
                <div style="border-bottom:1px solid #eee">
                    <a href="" style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">Ecommerce</a>
                </div>
                <p style="font-size:1.1em">Hi,</p>
                <p>Thank you for choosing Ecommerce. We received a request to change your password.</p>
                <p>To proceed with change your password, please click the following link:</p>
                <a href='<?php echo $reset_link; ?>'>
                    <h2 style="background: #00466a;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;">Reset Password</h2>
                </a>
                <p>If you didn't initiate this request, please ignore this email.</p>    
                <p style="font-size:0.9em;">Regards,<br />Ecommerce</p>
                    <hr style="border:none;border-top:1px solid #eee" />
                <!-- <div style="float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300">
                    <p>Your Brand Inc</p>
                    <p>1600 Amphitheatre Parkway</p>
                    <p>California</p>
                </div> -->
            </div>
        </div>
    </body>
</html>