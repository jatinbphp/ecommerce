<div class="gray py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url(''); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo site_url('profile-info'); ?>">Account</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<section class="middle">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="text-center d-block mb-5">
                    <h2>Checkout</h2>
                </div>
            </div>
        </div>
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php elseif($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <?php echo form_open_multipart('checkout/order/place', ['id' => 'CheckoutForm', 'class' => 'form-horizontal']); ?>
            <div class="row justify-content-between">
                <div class="col-12 col-lg-7 col-md-12">
                    <?php $this->load->view('front/Checkout/deliveryAddress'); ?>
                    <?php $this->load->view('front/Checkout/deliveryMethod'); ?>
                </div>
                <div class="col-12 col-lg-4 col-md-12">
                    <?php $this->load->view('front/Checkout/cartProducts'); ?>
                    <?php echo form_submit(['id' => 'checkoutSubmit', 'name' => 'submit', 'class' => 'btn btn-block btn-dark mb-3'], 'Place Your Order'); ?>
                </div>
            </div>
        <?php echo form_close(); ?>
    </div>
</section>
<script>
$(document).ready(function() {
    $('#checkoutSubmit').click(function(event) {
        var addressId = $('input[name="address_id"]:checked').val();
        $('#CheckoutForm').validate().destroy();
        if (addressId === '0') {
            $('#CheckoutForm').validate({
                rules: {
                    first_name: 'required',
                    last_name: 'required',
                    address_line1: 'required',
                    country: 'required',
                    state: 'required',
                    city: 'required',
                    pincode: 'required',
                    mobile_phone: {
                        required: true,
                        phoneUS: true
                    }
                },
                messages: {
                    first_name: "Please enter your first name",
                    last_name: "Please enter your last name",
                    address_line1: "Please enter your address line1 name",
                    country: "Please enter your country name",
                    state: "Please enter your state name",
                    city: "Please enter your city name",
                    pincode: "Please enter your pincode name",
                    mobile_phone: {
                        required: "Please enter your phone number",
                        phoneUS: "Please enter a valid phone number"
                    }
                },
                errorPlacement: function(error, element) {
                    var errorSpan = $('<span class="text-danger"></span>');
                    errorSpan.insertAfter(element);
                    error.appendTo(errorSpan);
                },
            });
            if ($('#CheckoutForm').valid()) {
                $('#CheckoutForm').submit();
            }
        } else {
            $('#CheckoutForm').submit();
        }
    });
});
</script>

