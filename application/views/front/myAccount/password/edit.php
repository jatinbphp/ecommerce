<div id="main-wrapper">
    <?php $this->load->view('Breadcrumb',['current' => $title, 'middle' => ['my_account' => 'profile-info']]); ?>
    <section class="middle">
        <div class="container">
            <?php $this->load->view('front/SessionMessages'); ?>
            <div class="row align-items-start justify-content-between">
                <?php $this->load->view('front/myAccount/common-file'); ?>
                <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                <form action="<?php echo base_url('change-password'); ?>" method="post" enctype="multipart/form-data">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label for="current_password" class="text-dark ft-medium">Current Password:<span style="color:red">*</span></label>
                            <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Current Password" >
                            <?php echo form_error('current_password', '<div class="text-danger">', '</div>'); ?>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label for="password" class="text-dark ft-medium">New Password:<span style="color:red">*</span></label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="New Password" >
                            <?php echo form_error('password', '<div class="text-danger">', '</div>'); ?>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label for="password_confirmation" class="text-dark ft-medium">Confirm Password:<span style="color:red">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password" >
                            <?php echo form_error('password_confirmation', '<div class="text-danger">', '</div>'); ?>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-dark">Update</button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#changepassword").addClass('active');
    });
</script>
