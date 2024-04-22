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

    var frontordersTable = $('#frontordersTable').DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:"fetch_orders",
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
        console.log(id);
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
                    url: "<?php echo site_url('addresses/delete/'); ?>" + id,
                    url: "addresses/delete/" + id,
                    type: "DELETE",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                    success: function(data) {
                        swal("Deleted", "Your data successfully deleted!", "success");
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
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
        console.log(itemId);
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
                    url: "my-wishlist-remove/" + itemId,
                    type: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            $this.closest('.product_grid').remove();
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
});