<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title w-100">
                        Sign Up
                    </h4>
                </div>
                <div class="card-body card-outline" style="max-width: 40rem; border-top: 3px solid #343a40;">
                <?php echo form_open('front/auth/AuthController/storeUser', 'id="registration_form", class=""'); ?>
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
                        ?>
                        <div class="position-relative">
                            <?php
                            echo form_password(array(
                                'name' => 'password',
                                'id' => 'password',
                                'class' => 'form-control',
                                'required' => 'required',
                                'placeholder' => 'Enter your password'
                            ));
                            ?>
                            <span class="eye-icon" onclick="togglePasswordVisibility()">
                                <i class="fa fa-eye pt-1" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php
                        echo form_label('Confirm Password <span class="text-danger">*</span>', 'confirm_password');
                        ?>
                        <div class="position-relative">
                            <?php
                            echo form_password(array(
                                'name' => 'confirm_password',
                                'id' => 'confirm_password',
                                'class' => 'form-control',
                                'required' => 'required',
                                'placeholder' => 'Confirm your password'
                            ));
                            ?>
                            <span class="confirm-eye-icon" onclick="toggleConfirmPasswordVisibility()">
                                <i class="fa fa-eye pt-1" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <?php
                                echo form_label('Country Code <span class="text-danger">*</span>', 'countryCode');
                                echo form_dropdown('countryCode', ($countryCode ?? []), '+91', 'class="form-control" id="countryCode" required');
                                ?>
                            </div>
                            <div class="col-md-8">
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
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="consentCheckbox">
                                    <span class="text-danger">*</span>
                                    <input type="checkbox" id="consentCheckbox" name="consentCheckbox" required>
                                        <span id="agreeConsent">I agree to receive SMS messages for login verification purposes.</span>
                                </label>
                            </div>

                        </div>
                    </div> -->

                    <?php
                        echo form_submit(array(
                        'name' => 'submit',
                        'class' => 'btn btn-md full-width bg-dark text-light fs-md ft-medium',
                        'value' => 'Create An Account'
                        ));
                    ?>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
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

    function toggleConfirmPasswordVisibility() {
        var passwordField = document.getElementById('confirm_password');
        var eyeIcon = document.querySelector('.confirm-eye-icon i');

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

    //signUp Validation code
    $(document).ready(function() {
        $.validator.addMethod("strongPassword", function(value, element) {
        return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/.test(value);
        }, "Your password must contain at least one lowercase letter, one uppercase letter, and one digit");
        $('#registration_form').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "<?php echo site_url('check-email-validation'); ?>",
                        type: "get"
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
                countryCode: {
                        required: true,
                },
                 mobileNo: {
                        required: true,
                        minlength: 10,
                        maxlength: 12
                },
                // consentCheckbox:{
                //     required: true,
                // }
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
                },
                countryCode: {
                    required: "Please select country code",
                },
                // consentCheckbox:{
                //     required: "Please agree to receive SMS messages for login verification purposes.",
                // }
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element).css('color', 'red');
            }
        });
    });
</script>
