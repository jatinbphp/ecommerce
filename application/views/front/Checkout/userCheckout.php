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
    var totalItems = $('#order_total_items').attr('data-total-item');
    if(totalItems == 0){
        $('#checkoutSubmit').prop('disabled',true);
    }
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
        var validationArray = getValidationArray();
        event.preventDefault();
        var cartData = localStorage.getItem('cartData');
        if(cartData){
            $('#userCart').val(cartData);
        }
        var addressId = $('input[name="address_id"]:checked').val();
        var shippingAddressId = $('input[name="shipping_address_id"]:checked').val();
        $('#CheckoutForm').validate().destroy();
        if (addressId === '0' || shippingAddressId === '0') {
            $('#CheckoutForm').validate(validationArray);
            var savedCard = $('input[name="saved_card"]:checked').val();
            if ($('#CheckoutForm').valid()) {
                if(savedCard != undefined && savedCard != 0){
                    payWithOldCard();
                } else {
                    payWithStripe();
                }
            }
        } else {
            var savedCard = $('input[name="saved_card"]:checked').val();
            if(savedCard != undefined && savedCard != 0){
                payWithOldCard();
            } else {
                payWithStripe();
            }
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
                $('#StripePaymentErrors').text(message);
                $('#StripePaymentErrors').fadeIn();
                $('.error-card').text('');
                $('.'+code).text(message);
            }
            return;
        }
        var addressId = $('input[name="address_id"]:checked').val();
        var fileds = {
            'first_name':'first_name',
            'last_name':'last_name',
            'line1':'address_line1',
            'line2':'address_line2',
            'country': 'country',
            'state':'state',
            'city': 'city',
            'postal_code':'pincode'
        };

        var billingAddress = {};
        var firstName = '';
        var lastName = '';
        $.each(fileds, function(index, value){
            if(addressId == 0){
                if(index == 'first_name'){
                    firstName = $('#'+value+'_'+addressId).val();
                    return;
                }
                if(index == 'last_name'){
                    lastName = $('#'+value+'_'+addressId).val();
                    return;
                }
                var elementVal = $('#'+value+'_'+addressId).val();
            } else {
                if(index == 'first_name'){
                    firstName = $('#'+value+'_'+addressId).text();
                    return;
                }
                if(index == 'last_name'){
                    lastName = $('#'+value+'_'+addressId).text();
                    return;
                }
                var elementVal = $('#'+value+'_'+addressId).text();
            }
            billingAddress[index] = elementVal;
        });

        var email = '';
        <?php if(isset($userEmail) && $userEmail): ?>
            email = '<?php echo $userEmail; ?>';    
        <?php else: ?>
            email = $('#email').val();    
        <?php endif; ?>

        var userName = firstName +' '+ lastName;
        stripe.createPaymentMethod({
            type: 'card',
            card: cardNumber,
            billing_details: {
                'address': billingAddress,
                'name': userName,
                'email': email,
            },
        }).then(stripePaymentMethodHandler);
    }

    function stripePaymentMethodHandler(result) {
        $('#loader').addClass('d-none');
        if (result.error) {
            // Show error in payment form
            $('#StripePaymentErrors').text(result.error.message);
            $('#StripePaymentErrors').fadeIn();
            $("#stripe-payment-success-3ds").modal('hide');
        } else {
            $("#stripe-payment-success-3ds").modal('show');
            var firstName = $('#first_name_0').val();
            var lastName = $('#last_name_0').val();
            var email    = $('#email').val();
            var userName = firstName+ ' ' +lastName;
            var address = $('#address_line1_0').val();
            var country = $('#country_0').val();
            var state   = $('#state_0').val();
            var city    = $('#city_0').val();
            var pincode = $('#pincode_0').val();
            var saveCard = $('#saveForLater').is(':checked');;
            var addressId = $('.addresses-radio:checked').val();

            var tockenName = getTockenName();
            var tockenValue = getTockenValue();
            var dataObj = {
                payment_method_id: result.paymentMethod.id,
                userName: userName,
                email: email,
                address: address,
                country: country,
                state: state,
                city: city,
                pincode: pincode,
                addressId: addressId,
                saveCard: saveCard,
            };
            dataObj[tockenName] = tockenValue;

            $.ajax({
                url: baseUrl + '/payment/process-payment',
                type: 'POST',
                dataType: 'json',
                data: dataObj,
                success: function(result) {
                    handleServerResponse(result);
                },
                error: function(xhr, status, error) {
                    // Handle error
                }
            }).always(function (dataOrjqXHR, textStatus, jqXHRorErrorThrown) {
                updateCsrfToken();
            });
        }
    }

    function payWithOldCard() {
        var intentId = $('input[name="saved_card"]:checked').val();
        $("#stripe-payment-success-3ds").modal('show');
        var firstName = $('#first_name_0').val();
        var lastName = $('#last_name_0').val();
        var email = $('#email').val();
        var userName = firstName + ' ' + lastName;
        var address = $('#address_line1_0').val();
        var country = $('#country_0').val();
        var state = $('#state_0').val();
        var city = $('#city_0').val();
        var pincode = $('#pincode_0').val();
        var saveCard = $('#saveForLater').is(':checked');
        var addressId = $('.addresses-radio:checked').val();

        var tockenName = getTockenName();
        var tockenValue = getTockenValue();
        var dataObj = {
            payment_method_id: intentId,
            userName: userName,
            email: email,
            address: address,
            country: country,
            state: state,
            city: city,
            pincode: pincode,
            addressId: addressId,
            saveCard: saveCard,
        };
        dataObj[tockenName] = tockenValue;

        $.ajax({
            url: baseUrl + '/payment/process-payment',
            type: 'POST',
            dataType: 'json',
            data: dataObj,
            success: function(result) {
                handleServerResponse(result);
            },
            error: function(xhr, status, error) {
                // Handle error
            }
        }).always(function (dataOrjqXHR, textStatus, jqXHRorErrorThrown) {
            updateCsrfToken();
        });
    }

    function handleServerResponse(response) {
        if (response.error) {
            $("#stripe-payment-success-3ds").modal('hide');
            swal("Error", response.error, "error");
            $("#pay_intent").val('');
            // Show error from server on payment form
        } else if (response.requires_action) {
            stripe.confirmCardPayment(
                response.payment_intent_client_secret
            ).then(handleStripeJsResult);
        } else {
            // Show success message
            $("#stripe-payment-success-3ds").modal('show');
            payment_intent_ID = response.intent;
            $("#pay_intent").val(payment_intent_ID);
            $("#stripe-payment-success-3ds").modal('hide');
            submitForm();
        }
    }

    function submitForm(){
        fetch(baseUrl+ 'get-tocken', {
            method: 'GET',
        }).then(function(result) {
            result.json().then(function(data) {
                $('input[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').val(data.csrf_token_value);
                $('#CheckoutForm').submit();
            })
        });
    }

    function handleStripeJsResult(result) {
        //console.log(result);
        if (result.error) {
            $("#stripe-payment-success-3ds").modal('hide');
            swal("Error", result.error.message, "error");
        } else {
            payment_intent_ID = result.paymentIntent.id;
            var firstName = $('#first_name_0').val();
            var lastName = $('#last_name_0').val();
            var email    = $('#email').val();
            var userName = firstName+ ' ' +lastName;
            var address = $('#address_line1_0').val();
            var country = $('#country_0').val();
            var state   = $('#state_0').val();
            var city    = $('#city_0').val();
            var pincode = $('#pincode_0').val();
            var addressId = $('.addresses-radio:checked').val();
            var saveCard = $('#saveForLater').is(':checked');

            var tockenName = getTockenName();
            var tockenValue = getTockenValue();
            var dataObj = {
                payment_intent_id: result.paymentIntent.id,
                userName: userName,
                email: email,
                address: address,
                country: country,
                state: state,
                city: city,
                pincode: pincode,
                addressId: addressId,
                saveCard: saveCard,
            };
            dataObj[tockenName] = tockenValue;

            $.ajax({
                url: baseUrl + '/payment/process-payment',
                type: 'POST',
                dataType: 'json',
                data: dataObj,
                success: function(confirmResult) {
                    handleServerResponse(confirmResult);
                },
                error: function(xhr, status, error) {
                    // Handle the error if needed
                    console.error('AJAX request failed:', status, error);
                }
            }).always(function (dataOrjqXHR, textStatus, jqXHRorErrorThrown) {
                updateCsrfToken();
            });
        }
    }

    $('.address').change(function() {
        var address = $('#address_line1_0').val();
        var country = $('#country_0').val();
        var state   = $('#state_0').val();
        var city    = $('#city_0').val();
        var pincode = $('#pincode_0').val();

        if(!address || !country || !state || !city || !pincode){
            return;
        }
        $('#loader').removeClass('d-none');
        var tockenName = getTockenName();
        var tockenValue = getTockenValue();
        var dataObj = {
            'address': address,
            'country': country,
            'state': state,
            'city': city,
            'pincode': pincode,
        };
        dataObj[tockenName] = tockenValue;
        $.ajax({
            url:  baseUrl+"payment/calculate-tax",
            type: "POST",
            data: dataObj,
            success: function(data){                   
                if(data.status == 1){
                    updateTaxValue(data);
                }
                $('#loader').addClass('d-none');
            }
        }).always(function (dataOrjqXHR, textStatus, jqXHRorErrorThrown) {
            updateCsrfToken();
        });
    });

    var selectedAddress = $('.addresses-radio:checked').val();

    if(selectedAddress != 0){
        updateTaxData(selectedAddress);
    }

    $('.addresses-radio').change(function(){
        var selectedAddress = $(this).val();
        updateTaxData(selectedAddress);
        copyBillingAddress();
    });

    $('#first_name_0, #last_name_0, #address_line1_0, #address_line2_0, #state_0, #city_0, #pincode_0, #mobile_phone_0').keyup(function(){
        var sameAsBilling = $('#same_as_billing:checked').val();
        if(sameAsBilling){
            $('#shipping_first_name').val($('#first_name_0').val());
            $('#shipping_last_name').val($('#last_name_0').val());
            $('#shipping_address_line1').val($('#address_line1_0').val());
            $('#shipping_address_line2').val($('#address_line2_0').val());
            $('#shipping_country').val($('#country_0').val());
            $('#shipping_state').val($('#state_0').val());
            $('#shipping_city').val($('#city_0').val());
            $('#shipping_pincode').val($('#pincode_0').val());
            $('#shipping_mobile_phone').val($('#mobile_phone_0').val());
        }
    });

    $('#country_0').change(function(){
        var sameAsBilling = $('#same_as_billing:checked').val();
        if(sameAsBilling){
            $('#shipping_country').val($('#country_0').val());
        }
    });

    $('#email').keyup(function(){
        var email = $(this).val();
        $.ajax({
            url:  baseUrl+"check-email",
            type: "GET",
            data: { 'email': email },
            success: function(data){           
                if(data.status == '0'){
                    swal({
                        title: "Welcome back!",
                        text: "Please sign in to continue. Don't worry, your cart data will be saved.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Login",
                        cancelButtonText: "Cancel"
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            // Redirect to the login pag    e
                            window.location.href = baseUrl+'signIn';
                        }
                    });
                }
            }
        }).always(function (dataOrjqXHR, textStatus, jqXHRorErrorThrown) {
            updateCsrfToken();
        });
    });
});

function updateTaxData(addressId) {
    $('#loader').removeClass('d-none');
    var tockenName = getTockenName();
    var tockenValue = getTockenValue();
    var dataObj = { 'addressId': addressId };
    dataObj[tockenName] = tockenValue;
    $.ajax({
        url:  baseUrl+"payment/calculate-tax-with-address",
        type: "POST",
        data: dataObj,
        success: function(data){                  
            if(data.status == 1){
                updateTaxValue(data);
            }
            $('#loader').addClass('d-none');
        }
    }).always(function (dataOrjqXHR, textStatus, jqXHRorErrorThrown) {
        updateCsrfToken();
    });
}

function updateTaxValue(data) {
    $('#tax-percentage').html(data.taxPercentage);
    $('#tax-amount').html('$'+data.taxAmount);
    $('#total-amount').html('$'+data.afterTaxAmount);
}

function getValidationArray(){
    var addressId = $('input[name="address_id"]:checked').val();
    var shippingAddressId = $('input[name="shipping_address_id"]:checked').val();
    var data = {};var shippingAddressId = $('input[name="shipping_address_id"]:checked').val();

    if (addressId == 0) {
        data = {
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
                    number: true,
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
            errorPlacement: commonErrorPlacement,
        }
    }

    if (shippingAddressId == 0) {
        if (!data.rules) {
            data.rules = {};
        }
        $.extend(data.rules, {
            shipping_first_name: 'required',
            shipping_last_name: 'required',
            shipping_address_line1: 'required',
            shipping_country: 'required',
            shipping_state: 'required',
            shipping_city: 'required',
            shipping_pincode: 'required',
            shipping_email: {
                required: true,
                email: true
            },
            shipping_mobile_phone: {
                required: true,
                minlength: 10,
                maxlength: 10,
                number: true,
            },
        });

        if (!data.messages) {
            data.messages = {};
        }
        $.extend(data.messages, {
            shipping_first_name: "Please enter your first name",
            shipping_last_name: "Please enter your last name",
            shipping_address_line1: "Please enter your address line1 name",
            shipping_country: "Please enter your country name",
            shipping_state: "Please enter your state name",
            shipping_city: "Please enter your city name",
            shipping_pincode: "Please enter your pincode name",
            shipping_mobile_phone: {
                required: "Please enter your phone number",
                minlength: "Your phone number must be at least {0} digits",
                maxlength: "Your phone number must not exceed {0} digits",
                number: "Please enter a valid phone number"
            },
            shipping_email: {
                required: "Please enter your email",
                email: "Please enter a valid email address"
            }
        });
        data.errorPlacement = commonErrorPlacement;
    }

    return data;
}

function commonErrorPlacement(error, element) {
    var errorSpan = $('<span class="text-danger"></span>');
    errorSpan.insertAfter(element);
    error.appendTo(errorSpan);
}

function copyBillingAddress(){
    var addressId = $('input[name="address_id"]:checked').val();
    var sameAsBilling = $('#same_as_billing:checked').val();
    if(!sameAsBilling){
        return;
    }

    var fileds = ['first_name','last_name','mobile_phone','address_line1','address_line2','country','state','city','pincode'];
    $.each(fileds, function(index, value){
        if(addressId == 0){
            var elementVal = $('#'+value+'_'+addressId).val();
        } else {
            var elementVal = $('#'+value+'_'+addressId).text();
        }
        $('#shipping_'+value).val(elementVal);
    });
}
</script>