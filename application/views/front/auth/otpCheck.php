<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title w-100">
                        OTP Verification
                    </h4>
                </div>
                <div class="card-body card-outline" style="max-width: 40rem; border-top: 3px solid #343a40;">
                    <?php $this->load->view('front/SessionMessages'); ?>
                    <?php echo form_open('verifyOtp'); ?>
                        <div class="form-group">
                            <?php echo form_label('Enter OTP <span class="text-danger">*</span>', 'otp'); ?>
                            <?php echo form_input(array('type' => 'text', 'class' => 'form-control', 'id' => 'otp', 'name' => 'otp', 'maxlength' => '6', 'required' => 'required')); ?>
                        </div>
                        <?php echo form_input(['type' => 'hidden', 'id' => 'userCart', 'name' => 'cartData', 'value' => '',]);?>
                        <?php echo form_submit(array('class' => 'btn btn-md full-width bg-dark text-light fs-md ft-medium', 'value' => 'Verify OTP', 'onClick'=>'verifyOtp()')); ?>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function verifyOtp(){
    var cartData = localStorage.getItem('cartData');
    if(cartData){
        $('#userCart').val(cartData);
        localStorage.removeItem('cartData');
    }
}
</script>