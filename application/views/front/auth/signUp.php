<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
                        Sign Up
                    </div>
                    <div class="card-body">
                        <?php echo form_open('front/auth/AuthController/storeUser', 'id="registration_form"'); ?>

                            <div class="form-group">
                                <?php
                                echo form_label('First Name <span class="text-danger">*</span>', 'fname');
                                echo form_input(array(
                                    'name' => 'fname',
                                    'id' => 'fname',
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'placeholder' => 'Enter your first name'
                                ));
                                ?>
                            </div>

                            <div class="form-group">
                                <?php
                                echo form_label('Last Name <span class="text-danger">*</span>', 'lname');
                                echo form_input(array(
                                    'name' => 'lname',
                                    'id' => 'lname',
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'placeholder' => 'Enter your last name'
                                ));
                                ?>
                            </div>

                            <div class="form-group">
                                <?php
                                echo form_label('Email <span class="text-danger">*</span>', 'email');
                                echo form_input(array(
                                    'type' => 'email',
                                    'name' => 'email',
                                    'id' => 'email',
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'placeholder' => 'Enter your email'
                                ));
                                ?>
                            </div>

                            <div class="form-group">
                                <?php
                                echo form_label('Password <span class="text-danger">*</span>', 'password');
                                echo form_password(array(
                                    'name' => 'password',
                                    'id' => 'password',
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'placeholder' => 'Enter your password'
                                ));
                                ?>
                            </div>

                            <div class="form-group">
                                <?php
                                echo form_label('Confirm Password <span class="text-danger">*</span>', 'confirm_password');
                                echo form_password(array(
                                    'name' => 'confirm_password',
                                    'id' => 'confirm_password',
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'placeholder' => 'Confirm your password'
                                ));
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                echo form_label('Mobile No <span class="text-danger">*</span>', 'mobileNo');
                                echo form_input(array(
                                    'type' => 'tel',
                                    'name' => 'mobileNo',
                                    'id' => 'mobileNo',
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'placeholder' => 'Enter your mobile number'
                                ));
                                ?>
                            </div>

                            <?php
                                echo form_submit(array(
                                'name' => 'submit',
                                'class' => 'btn btn-primary',
                                'value' => 'Sign Up'
                                ));
                            ?>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url('js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('js/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('js/jquery.validate.min.js'); ?>"></script>

<script type="text/javascript">
    //signUp Validation code
        $.validator.addMethod("strongPassword", function(value, element) {
        return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/.test(value);
        }, "Your password must contain at least one lowercase letter, one uppercase letter, and one digit");
        $('#registration_form').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "<?php echo site_url('check-email'); ?>",
                        type: "post"
                    }
                },
                 password: {
                        required: true,
                        minlength: 6,
                        strongPassword: true
                    },
                 fname: "required",
                 lname: "required",
                 confirm_password: {
                        required: true,
                        equalTo: "#password"
                },
                 mobileNo: {
                        required: true,
                        minlength: 10,
                        maxlength: 12
                }
            },
            messages: {
                 fname: "Please enter your first name",
                 lname: "Please enter your last name",

                email: {
                    required: "Please enter your email address",
                    email: "Please enter a valid email address",
                    remote: "Email already exists"
                },
                 password: {
                        required: "Please enter a password",
                        minlength: "Your password must be at least 6 characters long",
                        strongPassword: "Your password must contain at least one lowercase letter, one uppercase letter, and one digit"
                },
                 confirm_password: {
                        required: "Please confirm your password",
                        equalTo: "Passwords do not match"
                    },
                mobileNo: {
                    required: "Please enter your mobile number",
                    minlength: "Mobile number must be at least 10 characters long",
                    maxlength: "Mobile number can't be longer than 12 characters"
                }
            },
            errorPlacement: function(error, element) {
               error.insertAfter(element); 
               error.css('color', 'red');
            }

        });
    
</script>
