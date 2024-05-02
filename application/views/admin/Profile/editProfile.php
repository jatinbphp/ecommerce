<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo $page_title; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('admin/SessionMessages'); ?>
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Edit <?php echo $page_title; ?></h3>
                        </div>
                        <div class="card-body">
                            <?php echo form_open_multipart("admin/profile/edit/{$userData['id']}", ['id' => 'bannerFormEdit']); ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group <?php echo form_error('first_name') ? 'has-error' : ''; ?>">
                                            <?php echo form_label('First Name <span class="text-danger">*</span>', 'first_name'); ?>
                                            <?php echo form_input(['name' => 'first_name', 'id' => 'first_name', 'class' => 'form-control', 'placeholder' => 'Enter First Name','value' => isset($userData['first_name']) ? $userData['first_name'] : '']); ?>
                                            <?php echo form_error('first_name', '<span class="help-block text-danger">', '</span>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group <?php echo form_error('last_name') ? 'has-error' : ''; ?>">
                                            <?php echo form_label('Last Name <span class="text-danger">*</span>', 'name'); ?>
                                            <?php echo form_input(['name' => 'last_name', 'id' => 'last_name', 'class' => 'form-control', 'placeholder' => 'Enter Last Name', 'value' => isset($userData['last_name']) ? $userData['last_name'] : '']); ?>
                                            <?php echo form_error('last_name', '<span class="help-block text-danger">', '</span>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="callout callout-danger">
                                            <h4><i class="fa fa-info"></i> Note:</h4>
                                            <p>Leave Password and Confirm Password empty if you are not going to change the password.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group <?php echo form_error('password') ? 'has-error' : ''; ?>">
                                            <?php echo form_label('Password', 'password', ['class' => 'control-label']); ?>
                                            <?php echo form_password(['name' => 'password', 'id' => 'password', 'class' => 'form-control', 'placeholder' => 'Password']); ?>
                                            <?php echo form_error('password', '<span class="help-block text-danger">', '</span>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group <?php echo form_error('confirm_password') ? 'has-error' : ''; ?>">
                                            <?php echo form_label('Confirm Password', 'confirm_password', ['class' => 'control-label']); ?>
                                            <?php echo form_password(['name' => 'confirm_password', 'id' => 'confirm_password', 'class' => 'form-control', 'placeholder' => 'Confirm Password']); ?>
                                            <?php echo form_error('confirm_password', '<span class="help-block text-danger">', '</span>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group <?php echo form_error('image') ? 'has-error' : ''; ?>">
                                            <?php echo form_label('Image', 'image', ['class' => 'control-label']); ?>
                                            <div class="col-md-12">
                                                <div class="fileError">
                                                    <?php echo form_upload(['name' => 'image', 'id' => 'image', 'class' => '', 'accept' => 'image/*', 'onchange' => 'AjaxUploadImage(this)']); ?>
                                                </div>
                                                <?php if(!empty($userData['image']) && file_exists($userData['image'])): ?>
                                                    <img src="<?php echo base_url($userData['image']); ?>" alt="User Image" style="border: 1px solid #ccc; margin-top: 5px;" width="150" id="DisplayImage">
                                                <?php else: ?>
                                                    <img src="<?php echo base_url('images/default-image.png'); ?>" alt="User Image" style="border: 1px solid #ccc; margin-top: 5px; padding: 20px;" width="150" id="DisplayImage">
                                                <?php endif; ?>
                                            </div>
                                            <?php echo form_error('image', '<span class="help-block text-danger">', '</span>'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="<?php echo base_url('admin/dashboard') ?>" class="btn btn-sm btn-default">Back</a>
                                    <?php
                                        echo form_submit([
                                            'name' => 'submit',
                                            'class' => 'btn btn-sm btn-info float-right',
                                            'value' => 'Update'
                                        ]);
                                    ?>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<script type="text/javascript">
$(document).ready(function() {
    $("#profileTreeview").addClass('menu-open');
    $("#profileTreeview a:first").addClass('active');
    $("#profileEdit").addClass('active');
});
</script>

