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
        if(!id){
            return;
        }

        $.ajax({
            url: baseUrl+"wishlist/add_to_faviourits",
            type: "POST",
            data: {
                'id': id,
            },
            success: function(data) {
                if(data){
                    $('.wishlist-counter').text(data.total);
                    var msg = '';
                    if(data.type == 1){
                        msg = 'Your product was added to wishlist successfully!';
                    } else {
                        msg = 'Your product was removed from the wishlist successfully!';
                    }
                    updateWishlistClass(data.type, id);
                    SnackbarAlert(msg);
                } else {
                    SnackbarAlert("To add this product to your favorites, please log in to your account!");
                }
            }
        });
    });

    var frontordersTable = $('#frontordersTable').DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{
            url: baseUrl+"fetch_orders",
            type:"POST",
        },
        "columnDefs": [{
            "targets":[0,1],
            "orderable": false,
            "searchable": false,
        }],
    });
    
    //Delete Address
    $('.addresses-page').on('click', '.deleteRecord', function (event) {
        event.preventDefault();
        var id = $(this).attr("data-id");
        swal({
            title: "Are you sure?",
            text: "You want to delete this record?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: "No, cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: baseUrl+"addresses/delete/" + id,
                    type: "DELETE",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                    success: function(response) {
                        if (response.success) {
                            $('#address-box-'+id).remove();
                            swal("Success!", "Address removed successfully.", "success");
                        } else {
                            swal("Error", "Failed to remove item from wishlist.", "error");
                        }
                    }
                });

            } else {
                swal("Cancelled", "Your data safe!", "error");
            }
        });
    });

    //Delete product wishlist
    $(document).on('click', '.remove-item-wishlist', function(e) {
        e.preventDefault();
        var $this = $(this);
        var itemId = $this.data('id');
        
        swal({
            title: "Are you sure?",
            text: "You want to remove this item from your wishlist?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, Remove',
            cancelButtonText: "No, cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: baseUrl + "my-wishlist-remove/" + itemId,
                    type: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            $this.closest('.product_grid').remove();
                            $('.wishlist-counter').text(response.totalCount);
                            swal("Success!", "Item removed from wishlist successfully.", "success");
                           
                        } else {
                            swal("Error", "Failed to remove item from wishlist.", "error");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                swal("Cancelled", "Your data safe!", "error");
            }
        });
    });

    $('.show-more-reviews').click(function(){
        var desc = $(this).attr('data-description');
        $('#reviewDescbody').html(desc);
        $('#reviewDesc').modal('show');
    });

    $('#reviewForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var full_name = $('#reviewForm #full_name').val();
        var email_address = $('#reviewForm #email_address').val();
        var description = $('#reviewForm #description').val();

        $('.full_name-text').text('');
        $('.email_address-text').text('');
        $('.description-text').text('');

        if (!full_name) {
            $('.full_name-text').text('Full name field is required.');
            $('#full_name').focus();
            return false;
        }

        if (!email_address) {
            $('.email_address-text').text('Email address field is required.');
            $('#email_address').focus();
            return false;
        } else if (!isValidEmail(email_address)) {
            $('.email_address-text').text('Please enter a valid email address.');
            $('#email_address').focus();
            return false;
        }

        if (!description) {
            $('.description-text').text('Description field is required.');
            $('#description').focus();
            return false;
        }

        $.ajax({
            url: baseUrl+'reviews/add-review',
            type: 'POST',
            data: formData,
            success: function(response) {
                if(response.success){
                    $('#reviewForm')[0].reset();
                    $('#reviews_info').html(response.html);
                    $('#product_details').html(response.product_html);
                    initSlickSlider();
                }
                SnackbarAlert(response.message);
            }
        });
    });
});

function isValidEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

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

function updateWishlistClass(type, id){
    $('.snackbar-wishlist').each(function() {
        var dataId = $(this).data('id');
        if (dataId == id) {
            if(type == 1){
                $(this).addClass('active-wishlist');
            }else{
                $(this).removeClass('active-wishlist');
            }
        }
    });
}

function cancelOrder(button){
    var id = $(button).attr('data-id');
    if(!id || id==0){
        SnackbarAlert('something went wrong.');
        return;
    }
    $('#orderId').val(id);
    $('#cancelOrder').modal('show');
}
