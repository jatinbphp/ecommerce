$(document).ready(function() {
    $("#sendMessage").validate(
    {                
        rules:
        {     
            name:{
                required: true
            },
             email: {
                required: true,
                email: true,
            },
            subject:{
                required: true
            },
            message:{
                required: true
            },
        },
        messages:
        {
            name:'Please Enter Name.',
            email: {
                required: 'Please Enter Email address.',
                email: 'Please Enter a Valid Email Address.',
            },
            subject:'Please Enter Subject.',
            message:'Please Enter Message.',
        },
        errorPlacement: function(error, element) {
            // Place the error message in a span with class "text-danger"
            error.appendTo(element.closest(".form-group").find(".error-message"));
        },
        submitHandler: function(form)
        {
            form.submit();
        }
    });

    // Snackbar for wishlist Product
    $(document).on('click', '.snackbar-wishlist', function(event) {
        event.preventDefault();
        var id = $(this).attr("data-id");
        var self = $(this);

        $.ajax({
            url:"products/add_to_faviourits",
            type: "POST",
            data: {
                'id': id,
            },
            success: function(data) {
                if(data){
                    $('.wishlist-counter').text(data.total);
                    var msg = '';
                    if(data.type == 1){
                        self.addClass('active');
                        msg = 'Your product was added to wishlist successfully!';
                    } else {
                        self.removeClass('active');
                        msg = 'Your product was removed from the wishlist successfully!';
                    }
                    SnackbarAlert(msg);
                } else {
                    SnackbarAlert("To add this product to your favorites, please log in to your account!");
                }
            }
        });
    });
});

function SnackbarAlert(msg) {
    Snackbar.show({
        text: msg,
        pos: 'top-right',
        showAction: false,
        actionText: "Dismiss",
        duration: 3000,
        textColor: '#fff',
        backgroundColor: '#151515'
    });
}