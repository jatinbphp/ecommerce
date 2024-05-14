<?php $this->load->view('Breadcrumb',['current' => $title]); ?>
<section class="middle">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="text-center d-block mb-5">
                    <h2>Checkout</h2>
                </div>
            </div>
        </div>
        <?php $this->load->view('front/SessionMessages'); ?>
            <div class="row justify-content-between">
                <div class="col-12 col-lg-8 col-md-12">
                    <?php echo form_open_multipart('checkout/order/place', ['id' => 'CheckoutForm', 'class' => 'form-horizontal']); ?>
                        <?php $this->load->view('front/Checkout/deliveryAddress'); ?>
                        <?php $this->load->view('front/Checkout/paymentMethod'); ?>
                        <?php echo form_input(['type' => 'hidden', 'id' => 'token_id', 'name' => 'token_id']); ?>
                        <?php echo form_input(['type' => 'hidden', 'id' => 'pay_intent', 'name' => 'pay_intent']); ?>
                        <?php echo form_input(['type' => 'hidden', 'id' => 'userCart', 'name' => 'cartData', 'value' => '',]);?>
                    <?php echo form_close(); ?>
                </div>
                <div class="col-12 col-lg-4 col-md-12">
                    <div class="cart-sidbar">
                        <?php $this->load->view('front/Checkout/cartProducts'); ?>
                        <button type='button' id = 'checkoutSubmit' class = 'btn btn-block btn-dark mb-3'>Place Your Order</button>
                    </div>
                </div>
            </div>
    </div>
</section>
<div class="modal fade" id="stripe-payment-success-3ds" role="dialog" aria-labelledby="stripe-payment-success-3ds" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <i class="payment-success-content fa fa-check-circle" aria-hidden="true"></i>

                <div class="payment-process-content loader-spinner">Loading...</div>
                <h3 class="payment-process-content">Please wait! while we verify your payment.</h3>
                <h2 class="payment-success-content">Your payment was successful</h2>
                <p class="payment-success-content">Thank you for your payment.</p>
            </div>
        </div>
    </div>
</div>
<style>
    
</style>
<script>
$(document).ready(function() {
    var stripePublishableKey = '<?php echo $stripe_publishable_key; ?>';
    var stripe = Stripe(stripePublishableKey);
    var elements = stripe.elements();
    var style = {
        base: {
            color: "#000000",
            fontFamily: '"Montserrat", sans-serif',
            fontSmoothing: "antialiased",
            fontSize: "20px",
            "::placeholder": {
                color: "#aab7c4"
            }
        },
        invalid: {
            color: "#fa755a",
            iconColor: "#fa755a"
        },
    };


    var cardNumber = elements.create('cardNumber', {
        style: style,
        showIcon: true,
        iconStyle : 'solid',
        placeholder : 'Ex. 0000 0000 0000 0000'
    });
    cardNumber.mount('#card-number-element');

    var cardExpiry = elements.create('cardExpiry', {
        style: style
    });
    cardExpiry.mount('#card-expiry-element');

    var cardCvc = elements.create('cardCvc', {
        style: style
    });
    cardCvc.mount('#card-cvc-element');

    var postalCode = elements.create('postalCode', {
        style: style
    });
    postalCode.mount('#postal-code-element');

    // Handle real-time validation errors from the card Elements.
    [cardNumber, cardExpiry, cardCvc, postalCode].forEach(function(element) {
       element.on('change', function(event) {
            if (event.error) {
                $('#StripePaymentErrors').text(event.error.message).parent('div').addClass('alert alert-danger');
                $('#StripePaymentErrors').fadeIn();
            } else {
                $('#StripePaymentErrors').text('').parent('div').removeClass('alert alert-danger');
                $('#StripePaymentErrors').fadeOut();
            }
        });
    });

    $('#checkoutSubmit').click(function(event) {
        event.preventDefault();
        var cartData = localStorage.getItem('cartData');
        if(cartData){
            $('#userCart').val(cartData);
        }
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
                    email: {
                        required: true,
                        email: true
                    },
                    mobile_phone: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        number:true,
                    },
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
                        minlength: "Your phone number must be at least {0} digits",
                        maxlength: "Your phone number must not exceed {0} digits",
                        number: "Please enter a valid phone number"
                    },
                    email: {
                        required: "Please enter your email",
                        email: "Please enter a valid email address"
                    }
                },
                errorPlacement: function(error, element) {
                    var errorSpan = $('<span class="text-danger"></span>');
                    errorSpan.insertAfter(element);
                    error.appendTo(errorSpan);
                },
            });
            if ($('#CheckoutForm').valid()) {
                payWithStripe();
            }
        } else {
            payWithStripe();
        }
    });

    async function payWithStripe() {
        $('#loader').removeClass('d-none');
        var {token, error} = await stripe.createToken(cardNumber);

        if (error) {
            $('#loader').addClass('d-none');
            var code = error.code ? error.code : '';
            var message = error.message ? error.message : '';
            if(code && message){
                $('.error-card').text('');
                $('.'+code).text(message);
            }
            return;
        }

        stripe.createPaymentMethod({
            type: 'card',
            card: cardNumber,
        }).then(stripePaymentMethodHandler);
    }

    function stripePaymentMethodHandler(result) {
        $('#loader').addClass('d-none');
        if (result.error) {
            // Show error in payment form
            $('#StripePaymentErrors').text(result.error.message);
            $('#StripePaymentErrors').fadeIn();
            //$('.loading').fadeOut();
            $("#stripe-payment-success-3ds").modal('hide');
        } else {
            // Otherwise send paymentMethod.id to your server (see Step 4)
            $("#stripe-payment-success-3ds").modal('show');
            var firstName = $('#first_name').val();
            var lastName = $('#last_name').val();
            var email    = $('#email').val();
            var userName = firstName+ ' ' +lastName;
            var address = $('#address_line1').val();
            var country = $('#country').val();
            var state   = $('#state').val();
            var city    = $('#city').val();
            var pincode = $('#pincode').val();
            var addressId = $('.addresses-radio:checked').val();
            fetch(baseUrl+ '/payment/process-payment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    payment_method_id: result.paymentMethod.id,
                    userName: userName,
                    email: email,
                    address: address,
                    country: country,
                    state: state,
                    city: city,
                    pincode: pincode,
                    addressId: addressId,
                })
            }).then(function(result) {
                // Handle server response (see Step 4)
                result.json().then(function(json) {
                    handleServerResponse(json);
                })
            });
        }
    }

    function handleServerResponse(response) {
        if (response.error) {
            //$('.loading').fadeOut();
            $("#stripe-payment-success-3ds").modal('hide');
            swal("Cancelled", response.error, "error");
            $("#pay_intent").val('');
            // Show error from server on payment form
        } else if (response.requires_action) {
            // Use Stripe.js to handle required card action
            stripe.confirmCardPayment(
                response.payment_intent_client_secret
            ).then(handleStripeJsResult);
        } else {
            // Show success message
            $("#stripe-payment-success-3ds").modal('show');
            //console.log(response);
            //payment_intent_ID
            payment_intent_ID = response.intent;
            $("#pay_intent").val(payment_intent_ID);
            //$('.loading').fadeOut();
            $("#stripe-payment-success-3ds").modal('hide');
            $('#CheckoutForm').submit();
        }
    }

    function handleStripeJsResult(result) {
        //console.log(result);
        if (result.error) {
            $("#stripe-payment-success-3ds").modal('hide');
            // Show error in payment form
            swal("Cancelled", result.error.message, "error");
        } else {
            payment_intent_ID = result.paymentIntent.id;
            //alert("Handle script else");
            // The card action has been handled
            // The PaymentIntent can be confirmed again on the server
            var firstName = $('#first_name').val();
            var lastName = $('#last_name').val();
            var email    = $('#email').val();
            var userName = firstName+ ' ' +lastName;
            var address = $('#address_line1').val();
            var country = $('#country').val();
            var state   = $('#state').val();
            var city    = $('#city').val();
            var pincode = $('#pincode').val();
            var addressId = $('.addresses-radio:checked').val();
            fetch(baseUrl+ '/payment/process-payment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    payment_intent_id: result.paymentIntent.id,
                    userName: userName,
                    email: email,
                    address: address,
                    country: country,
                    state: state,
                    city: city,
                    pincode: pincode,
                    addressId: addressId,
                })
            }).then(function(confirmResult) {
                // console.log(confirmResult);
                // alert("Handle script feth then");
                // console.log(confirmResult);
                return confirmResult.json();
            }).then(handleServerResponse);
        }
    }

    $('.address').change(function() {
        var address = $('#address_line1').val();
        var country = $('#country').val();
        var state   = $('#state').val();
        var city    = $('#city').val();
        var pincode = $('#pincode').val();

        if(!address || !country || !state || !city || !pincode){
            return;
        }
        $('#loader').removeClass('d-none');
        $.ajax({
            url:  baseUrl+"payment/calculate-tax",
            type: "POST",
            data: {
                'address': address,
                'country': country,
                'state': state,
                'city': city,
                'pincode': pincode,
            },
            success: function(data){                   
                if(data.status == 1){
                    updateTaxValue(data);
                }
                $('#loader').addClass('d-none');
            }
        });
    });

    var selectedAddress = $('.addresses-radio:checked').val();

    if(selectedAddress != 0){
        updateTaxData(selectedAddress);
    }

    $('.addresses-radio').change(function(){
        var selectedAddress = $(this).val();
        updateTaxData(selectedAddress);
    });
});

function updateTaxData(addressId) {
    $('#loader').removeClass('d-none');
    $.ajax({
        url:  baseUrl+"payment/calculate-tax-with-address",
        type: "POST",
        data: {
            'addressId': addressId,
        },
        success: function(data){                  
            if(data.status == 1){
                updateTaxValue(data);
            }
            $('#loader').addClass('d-none');
        }
    });
}

function updateTaxValue(data) {
    $('#tax-percentage').html(data.taxPercentage);
    $('#tax-amount').html('$'+data.taxAmount);
    $('#total-amount').html('$'+data.afterTaxAmount);
}
</script>