
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <?php
                                    echo form_label('First Name <span class="text-danger">*</span>', 'fname');
                                    echo form_input('first_name', isset($userData['first_name']) ? $userData['first_name'] : set_value('first_name'), 'class="form-control chk-required" placeholder="Enter First Name"');
                                    echo form_error('first_name', '<span class="help-block text-danger">', '</span>');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <?php
                                    echo form_label('Last Name <span class="text-danger">*</span>', 'fname');
                                    echo form_input('last_name', isset($userData['last_name']) ? $userData['last_name'] : set_value('last_name'), 'class="form-control chk-required" placeholder="Enter Last Name"');
                                    echo form_error('last_name', '<span class="help-block text-danger">', '</span>');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                                echo form_label('Email <span class="text-danger">*</span>', 'email');
                            echo form_input(array('name' => 'email','id' => 'email','value' => isset($userData['email']) ? $userData['email'] : set_value('email'),'type' => 'email','class' => 'form-control chk-required','placeholder' => 'Enter Email'));
                                echo form_error('email', '<span class="help-block text-danger">', '</span>');
                            ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <?php
                                        echo form_label('Country Code <span class="text-danger">*</span>', 'countryCode');
                                        echo form_dropdown('countryCode', $countryCodes, isset($userData['country_code']) ? $userData['country_code'] : set_value('countryCode', '+91'), 'class="form-control chk-required" id="countryCode" required');
                                        echo form_error('countryCode', '<span class="help-block text-danger">', '</span>');
                                    ?>
                                </div>
                                <div class="col-md-8">
                                    <?php
                                    echo form_label('Mobile No <span class="text-danger">*</span>', 'mobileNo');
                                    echo form_input(array('name' => 'mobileNo','id' => 'mobileNo','value' => isset($userData['phone']) ? $userData['phone'] : set_value('mobileNo'),'type' => 'tel','class' => 'form-control chk-required','required' => 'required','placeholder' => 'Enter your mobile number'));

                                    echo form_error('mobileNo', '<span class="help-block text-danger">', '</span>');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if(isset($userData)): ?>
                        <div class="col-md-12">
                            <div class="callout callout-danger">
                                <h4><i class="fa fa-info"></i> Note:</h4>
                                <p>Leave Password and Confirm Password empty if you are not going to change the password.</p>
                            </div>
                        </div>
                    <?php endif ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                                if(isset($userData)):
                                    echo form_label('Password', 'password');
                                    echo form_password('password', '', 'id="password" class="form-control usr-pass-field" placeholder="Enter your password"');

                                else:
                                    echo form_label('Password <span class="text-danger">*</span>', 'password');
                                    echo form_password('password', '', 'id="password" class="form-control" placeholder="Enter your password" required = "required"');
                                endif;
                                echo form_error('password', '<span class="help-block text-danger">', '</span>');
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                                if(isset($userData)):
                                    echo form_label('Confirm Password', 'confirm_password');
                                    echo form_password('confirm_password', '', 'id="confirm_password" class="form-control usr-confpass-field" placeholder="Confirm your password"');
                                else:
                                    echo form_label('Confirm Password', 'confirm_password');
                                    echo form_password('confirm_password', '', 'id="confirm_password" class="form-control" placeholder="Confirm your password"');
                                endif;

                                echo form_error('confirm_password', '<span class="help-block text-danger">', '</span>');
                            ?>
                        </div>
                    </div>                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                                echo form_label('Image :');
                            ?>
                            <div class="">
                                <div class="fileError">
                                    <?php echo form_upload('image', '', 'id="image" onchange="AjaxUploadImage(this)" accept="image/*"');
                                    echo form_error('image', '<span class="help-block text-danger">', '</span>'); ?>
                                </div>
                                
                                <?php if(!empty($userData['image']) && file_exists($userData['image'])): ?>
                                    <img src="<?php echo base_url($userData['image']); ?>" alt="User Image" style="border: 1px solid #ccc; margin-top: 5px;" width="150" id="DisplayImage">
                                <?php else: ?>
                                    <img src="<?php echo base_url('images/default-image.png'); ?>" alt="User Image" style="border: 1px solid #ccc; margin-top: 5px; padding: 20px;" width="150" id="DisplayImage">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                                echo form_label('Status :');
                            ?>
                            <div class="">
                                <?php foreach ($status as $key => $value): ?>
                                <?php $checked = !isset($users) && $key == 'active' ? 'checked' : ''; ?>    
                                <label>
                                    <?php echo form_radio('status', $key, $checked, 'class="flat-red"'); ?>
                                    <span style="margin-right: 10px"><?php echo $value; ?></span>
                                </label>
                            <?php endforeach; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
