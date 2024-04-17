document.addEventListener('DOMContentLoaded', function() {
    var stripe = Stripe('');
    var elements = stripe.elements();
    // var cardElement = elements.create('card');
    // cardElement.mount('#card-element');

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
        //iconStyle : 'solid',
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
            //var displayError = document.getElementById('card-errors');
            if (event.error) {
                //displayError.textContent = event.error.message;
                $('#StripePaymentErrors').text(event.error.message);
                $('#StripePaymentErrors').fadeIn();
            } else {
                //displayError.textContent = '';
                $('#StripePaymentErrors').text('');
                $('#StripePaymentErrors').fadeOut();
            }
        });
    });

    var form = document.getElementById('payment-form');
    var submitButton = document.getElementById('submit-button');

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        payWithStripe(stripe, cardNumber);
    });

    async function payWithStripe(stripe, cardElement) {
        var {token, error} = await stripe.createToken(cardNumber);

        if (error) {
            console.error(error);
        } else {
            var data = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                amount: document.getElementById('amount').value,
                stripeToken: token.id
            };

            fetch(baseUrl+ '/payment/process-payment', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Payment successful!');
                } else {
                    console.log(data);
                    alert('Payment failed.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }
});
