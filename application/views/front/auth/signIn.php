<div class="container">
    <div class="row justify-content-center  mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title w-100">
                        Login
                    </h4>
                </div>
                <div class="card-body card-outline" style="max-width: 40rem; border-top: 3px solid #343a40;">
                    <?php $this->load->view('front/SessionMessages'); ?>
                    <?php echo form_open('authUser', array('class' => '')); ?>
                        <div class="form-group">
                            <?php echo form_label('Email Address <span class="text-danger">*</span>', 'email'); ?>
                            <?php echo form_input(array('type' => 'email', 'class' => 'form-control', 'id' => 'email', 'name' => 'email', 'required' => 'required','placeholder' => 'Enter your email')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo form_label('Password <span class="text-danger">*</span>', 'password'); ?>
                            <div class="position-relative">
                                <?php echo form_input(array('type' => 'password', 'class' => 'form-control', 'id' => 'password', 'name' => 'password', 'required' => 'required', 'placeholder' => 'Enter your password')); ?>
                                <span class="eye-icon" onclick="togglePasswordVisibility()">
                                    <i class="fa fa-eye pt-1" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <div class="flex-1">
                                    <p>Don't have an account? <?php echo anchor('signup', 'Sign Up'); ?></p>
                                </div>
                                <div class="eltio_k2">
                                    <p><a href="<?php echo site_url('forgotPassword'); ?>">Forgot Password?</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo form_submit(array('class' => 'btn btn-md full-width bg-dark text-light fs-md ft-medium', 'value' => 'Login')); ?>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
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