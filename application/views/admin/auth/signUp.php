    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
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
