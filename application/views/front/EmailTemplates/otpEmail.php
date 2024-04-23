<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>OTP Email</title>
    </head>
    <body>
        <div style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
            <div style="width:100%;padding:20px 0">
                <div style="border-bottom:1px solid #eee">
                    <a href="" style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">Ecommerce</a>
                </div>
                <p style="font-size:1.1em">Hi,</p>
                <p>Thank you for choosing Ecommerce. Use the following OTP to complete your Sign Up procedures.</p>
                <h2 style="background: #00466a;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;"><?php echo $otpCode; ?></h2>
                    <p>If you didn't request this OTP, please ignore this email.</p>    
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
