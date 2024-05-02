<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ecommerce | Log in</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url('public/assets/admin/dist/css/adminlte.min.css') ?>">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <b>Ecommerce</b> <br>Admin
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <?php $this->load->view('admin/SessionMessages'); ?>
                <?php echo form_open('admin/logIn'); ?>
                    <div class="form-group">
                        <?php echo form_input(['type' => 'email', 'class' => 'form-control', 'id' => 'email', 'name' => 'email', 'required' => 'required','placeholder' => 'Email']); ?>
                    </div>
                    <div class="form-group mt-4">
                        <?php echo form_input(['type' => 'password', 'class' => 'form-control', 'id' => 'password', 'name' => 'password', 'required' => 'required', 'placeholder' => 'Password']); ?>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                        </div>
                        <div class="col-sm-4 text-right">
                            <?php echo form_submit(['class' => 'btn btn-danger btn-block btn-flat', 'value' => 'Sign In']); ?>
                        </div>
                    </div>
                <?php echo form_close(); ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url('js/jquery.min.js'); ?>"></script>
</body>
</html>
