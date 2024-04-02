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
                            <?php echo form_input(array('type' => 'password', 'class' => 'form-control', 'id' => 'password', 'name' => 'password', 'required' => 'required', 'placeholder' => 'Enter your password')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo form_submit(array('class' => 'btn btn-primary btn-block', 'value' => 'Sign In')); ?>
                        </div>
                    <?php echo form_close(); ?>
                    <p class="text-center">Don't have an account? <?php echo anchor('signup', 'Sign Up'); ?></p>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url('js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('js/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('js/bootstrap.min.js'); ?>"></script>

</body>
</html>