<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="<?php echo base_url('css/bootstrap.min.css'); ?>" rel="stylesheet">
    <style>
        /* Custom CSS for logo and background color */
        body {
            background-color: #f8f9fa; /* Set your desired background color */
        }
        .company-logo {
            max-width: 200px; /* Adjust the size of the logo as needed */
            margin-bottom: 20px; /* Add some margin below the logo */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <img src="<?php echo base_url('images/logo.png')?>" class="company-logo mx-auto d-block" alt="Company Logo">
                <div class="card">
                    <div class="card-header">
                        OTP Verification
                    </div>
                    <div class="card-body">
                        <?php echo form_open('verifyOtp'); ?>
                            <?php if ($this->session->flashdata('error')) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <?php echo form_label('Enter OTP <span class="text-danger">*</span>', 'otp'); ?>
                                    <div class="alert alert-warning" role="alert">
                                        Please Enter Test OTP : 123456
                                    </div>
                                <?php echo form_input(array('type' => 'text', 'class' => 'form-control', 'id' => 'otp', 'name' => 'otp', 'maxlength' => '6', 'required' => 'required')); ?>
                            </div>
                            <?php echo form_submit(array('class' => 'btn btn-primary', 'value' => 'Verify OTP')); ?>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url('js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('js/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('js/bootstrap.min.js'); ?>"></script>

</body>
</html>