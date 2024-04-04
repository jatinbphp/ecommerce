<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div>
                    <img src="<?php echo base_url('images/logo.png')?>" class="company-logo mx-auto d-block" alt="Company Logo">
                    <?php if ($this->session->flashdata('success_message')): ?>
                        <div class="alert alert-success">
                            <?php echo $this->session->flashdata('success_message'); ?>
                        </div>
                    <?php endif; ?>
                     <?php if ($this->session->flashdata('error')) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        <?php } ?>

                    <?php echo form_open(base_url('updateNewPassword'),'id="resetPasswordForm"'); ?>
                        <div class="form-group">
                            <?php echo form_hidden('token', $token); ?>
                            <?php echo form_label('New Password:', 'password'); ?>
                            <?php echo form_input(array('type' => 'password', 'class' => 'form-control', 'name' => 'password', 'id' => 'password', 'required' => 'required', 'placeholder' => 'Enter new password')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo form_label('Retype Password:', 'confirm_password'); ?>
                            <?php echo form_input(array('type' => 'password','class' => 'form-control', 'name' => 'confirm_password', 'id' => 'confirm_password', 'required' => 'required' , 'placeholder' => 'Enter new password again')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo form_submit(array('class' => 'btn btn-primary btn-block', 'value' => 'Submit')); ?>
                        </div>
                    <?php echo form_close(); ?>
                    
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url('js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('js/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('js/jquery.validate.min.js'); ?>"></script>

</body>
</html>
<script type="text/javascript">
        $.validator.addMethod("strongPassword", function(value, element) {
        return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/.test(value);
        }, "Your password must contain at least one lowercase letter, one uppercase letter, and one digit");
        $('#resetPasswordForm').validate({
            rules: {
                 password: {
                        required: true,
                        minlength: 6,
                        strongPassword: true
                    },
                 confirm_password: {
                        required: true,
                        equalTo: "#password"
                }
            },
            messages: {
                 password: {
                        required: "Please enter a password",
                        minlength: "Your password must be at least 6 characters long",
                        strongPassword: "Your password must contain at least one lowercase letter, one uppercase letter, and one digit"
                },
                 confirm_password: {
                        required: "Please confirm your password",
                        equalTo: "Passwords do not match"
                    },
            },
            errorPlacement: function(error, element) {
               error.insertAfter(element); 
               error.css('color', 'red');
            }

        });
    
</script>
