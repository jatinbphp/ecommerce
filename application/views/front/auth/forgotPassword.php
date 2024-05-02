<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Forgot Password
                </div>
                <div class="card-body card-outline" style="max-width: 40rem; border-top: 3px solid #343a40;">
                    <?php $this->load->view('front/SessionMessages'); ?>
                    <?php echo form_open('sendforgotPasswordLink'); ?>
                        <div class="form-group">
                            <?php echo form_label('Email Address <span class="text-danger">*</span>', 'otp'); ?>
                            <?php echo form_input(array('type' => 'email', 'class' => 'form-control', 'id' => 'email', 'name' => 'email', 'required' => 'required')); ?>
                        </div>
                        <?php echo form_submit(array('class' => 'btn btn-md full-width bg-dark text-light fs-md ft-medium', 'value' => 'Send Request')); ?>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>