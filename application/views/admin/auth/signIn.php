<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="<?php echo base_url('css/bootstrap.min.css'); ?>" rel="stylesheet">

</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div>
                    <h2 class="text-center text-muted">Ecommerce</h2>
                    <h4 class="text-center text-muted">Admin</h4>

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
                    <div class="card mt-4">
                    <div class="card-body">
                        <?php echo form_open('admin/logIn'); ?>
                            <div class="text-center text-muted">Sign in to start your session</div>
                            <div class="form-group mt-4">
                                <?php echo form_input(array('type' => 'email', 'class' => 'form-control', 'id' => 'email', 'name' => 'email', 'required' => 'required','placeholder' => 'Enter your email')); ?>
                            </div>
                            <div class="form-group mt-4">
                                <?php echo form_input(array('type' => 'password', 'class' => 'form-control', 'id' => 'password', 'name' => 'password', 'required' => 'required', 'placeholder' => 'Enter your password')); ?>
                            </div>
                            <div class="form-group mt-4">
                                <?php echo form_submit(array('class' => 'btn btn-primary btn-block', 'value' => 'Sign In')); ?>
                            </div>
                        <?php echo form_close(); ?>
                     </div>
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