<div class="row tab-pane fade show active" id="content1">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <?php
                                    echo form_label('First Name <span class="text-danger">*</span>', 'fname');
                                    echo form_input([
                                        'name' => 'first_name',
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter First Name'
                                    ]);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <?php
                                    echo form_label('Last Name <span class="text-danger">*</span>', 'fname');
                                    echo form_input([
                                        'name' => 'last_name',
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter Last Name'
                                    ]);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                                echo form_label('Email <span class="text-danger">*</span>', 'email');
                                echo form_input([
                                    'type' => 'email',
                                    'name' => 'email',
                                    'id' => 'email',
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter Email'
                                ]);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                                echo form_label('Mobile No <span class="text-danger">*</span>', 'mobileNo');
                                echo form_input([
                                    'type' => 'tel',
                                    'name' => 'phone',
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter Mobile number'
                                ]);
                            ?>
                        </div>
                    </div>
                    <?php if(isset($user)): ?>
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
                                echo form_label('Password <span class="text-danger">*</span>', 'password');
                                echo form_password([
                                    'name' => 'password',
                                    'id' => 'password',
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter your password'
                                ]);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                                echo form_label('Confirm Password <span class="text-danger">*</span>', 'confirm_password');
                                echo form_password(array(
                                    'name' => 'confirm_password',
                                    'id' => 'confirm_password',
                                    'class' => 'form-control',
                                    'placeholder' => 'Confirm your password'
                                ));
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
                                    <?php echo form_open_multipart('', ['id' => 'image']); ?>
                                        <input type="file" name="userfile" id="image" accept="image/*" onchange="AjaxUploadImage(this)">
                                    <?php echo form_close(); ?>
                                </div>
                                
                                <?php if(!empty($user['image']) && file_exists($user['image'])): ?>
                                    <img src="<?php echo base_url($user['image']); ?>" alt="User Image" style="border: 1px solid #ccc; margin-top: 5px;" width="150" id="DisplayImage">
                                <?php else: ?>
                                    <img src="<?php echo base_url('public/assets/admin/dist/img/no-image.png'); ?>" alt="User Image" style="border: 1px solid #ccc; margin-top: 5px; padding: 20px;" width="150" id="DisplayImage">
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
                                        <input type="radio" name="status" value="<?php echo $key; ?>" class="flat-red" <?php echo $checked; ?>>
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
</div>
