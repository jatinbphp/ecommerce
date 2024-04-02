    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        OTP Verification
                    </div>
                    <div class="card-body">
                        <?php echo form_open('verifyOtp'); ?>
                            <?php if ($this->session->flashdata('error')) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <?php echo form_label('Enter OTP <span class="text-danger">*</span>', 'otp'); ?>
                                <?php echo form_input(array('type' => 'text', 'class' => 'form-control', 'id' => 'otp', 'name' => 'otp', 'maxlength' => '6', 'minlength' => '6', 'required' => 'required')); ?>
                            </div>
                            <?php echo form_submit(array('class' => 'btn btn-primary', 'value' => 'Verify OTP')); ?>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
