<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="<?php echo base_url('css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/plugins/font-awesome.css'); ?>" rel="stylesheet">
    <style>
        /* Custom CSS for logo and background color */
        body {
            background-color: #f8f9fa; /* Set your desired background color */
        }
        .company-logo {
            max-width: 200px; /* Adjust the size of the logo as needed */
            margin-bottom: 20px; /* Add some margin below the logo */
        }
        .eye-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            pointer-events: auto;
            color:gray;
        }
        .eye-icon i {
            pointer-events: none;
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

                    <?php echo form_open('authUser'); ?>
                        <div class="form-group">
                            <?php echo form_label('Email', 'email'); ?>
                            <?php echo form_input(array('type' => 'email', 'class' => 'form-control', 'id' => 'email', 'name' => 'email', 'required' => 'required','placeholder' => 'Enter your email')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo form_label('Password', 'password'); ?>
                            <div class="position-relative">
                                <?php echo form_input(array('type' => 'password', 'class' => 'form-control', 'id' => 'password', 'name' => 'password', 'required' => 'required', 'placeholder' => 'Enter your password')); ?>
                                <span class="eye-icon" onclick="togglePasswordVisibility()">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo form_submit(array('class' => 'btn btn-primary btn-block', 'value' => 'Sign In')); ?>
                        </div>
                    <?php echo form_close(); ?>
                    <div class="d-flex justify-content-between">
                        <p>Don't have an account? <?php echo anchor('signup', 'Sign Up'); ?></p>
                        <p><a href="<?php echo site_url('forgotPassword'); ?>">Forgot Password?</a></p>
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
<script>
        function togglePasswordVisibility() {
            var passwordField = document.getElementById('password');
            var eyeIcon = document.querySelector('.eye-icon i');

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
</script>