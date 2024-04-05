$(document).ready(function() {
    var category_table = $('#CategoriesTable').DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:"categories/fetch_categories",
            type:"POST",
        },
        "columnDefs": [{
            "targets":[4],
            "orderable": false
        }]
    });

    $("#categories_form").validate(
    {                
        rules:
        {     
            name:{
                required: true
            }
        },
        messages:
        {
            name:'Please enter Category Name.',
        },
        submitHandler: function(form)
        {
            form.submit();
        }
    });

    //Admin Delete
    $("#CategoriesTable").on('click', '.deleteRecord', function(event) {
        event.preventDefault();
        var id = $(this).attr("data-id");
        var controller = $(this).attr("data-controller");
        var title = $(this).attr("data-title");
        swal({
            title: "Are you sure?",
            text: "You want to delete "+title+"?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'No, cancel',
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: controller+"/delete/" + id,
                    type: "POST",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                    success: function(data){
                        category_table.row('.selected').remove().draw(false);
                        swal("Deleted", "Your data successfully deleted!", "success");
                    }
                })
            } else {
                swal("Cancelled", yourDataSafe, "error");
            }
        });
    });

    var user_table = $('#usersTable').DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{

            url:"users/fetch_users",
            type:"POST"
        },
        "columnDefs": [{
            "targets":[5,6],
            "orderable": false
        }]
    });

    $("#CategoriesTable, #usersTable").on('click', '.assign_unassign', function(event) {
        event.preventDefault();
        var url = $(this).attr('data-url');
        var id = $(this).attr("data-id");
        var type = $(this).attr("data-type");
        var table_name = $(this).attr("data-table_name");

        var l = Ladda.create(this);
        l.start();
        $.ajax({
            url: url,
            type: "post",
            data: {
                'id': id,
                'type': type,
                'table_name': table_name,
            },
            success: function(data){
                l.stop();
                console.log(type);
                if(type=='unassign'){
                    $('#assign_remove_'+id).hide();
                    $('#assign_add_'+id).show();
                } else {
                    $('#assign_remove_'+id).show();
                    $('#assign_add_'+id).hide();
                }
            }
        });
    });

    $.validator.addMethod("strongPassword", function(value, element) {
        return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/.test(value);
        }, "Your password must contain at least one lowercase letter, one uppercase letter, and one digit");

    $("#user_create_form").validate(
    {   
        rules: {
            email: {
                required: true,
                email: true,
                remote: {
                    url: baseUrl+"check-email",
                    type: "post"
                }
            },
             password: {
                    required: true,
                    minlength: 6,
                    strongPassword: true
                },
             fname: "required",
             lname: "required",
             confirm_password: {
                    required: true,
                    equalTo: "#password"
            },
            countryCode: {
                    required: true,
            },
             mobileNo: {
                    required: true,
                    minlength: 10,
                    maxlength: 12
            }
        },
        messages: {
             fname: "Please enter your first name",
             lname: "Please enter your last name",

            email: {
                required: "Please enter your email address",
                email: "Please enter a valid email address",
                remote: "Email already exists"
            },
             password: {
                    required: "Please enter a password",
                    minlength: "Your password must be at least 6 characters long",
                    strongPassword: "Your password must contain at least one lowercase letter, one uppercase letter, and one digit"
            },
             confirm_password: {
                    required: "Please confirm your password",
                    equalTo: "Passwords do not match"
                },
            countryCode: {
                required: "Please select country code",
            },
            mobileNo: {
                required: "Please enter your mobile number",
                minlength: "Mobile number must be at least 10 characters long",
                maxlength: "Mobile number can't be longer than 12 characters"
            },
            countryCode: {
                required: "Please select country code",
            }
        },
        errorPlacement: function(error, element) {
           error.insertAfter(element).css('color', 'red');
        },
        submitHandler: function(form)
        {
            form.submit();
        }
    });

    $("#user_edit_form").validate(
    {   
        rules: {
            email: {
                required: true,
                email: true,
            },
             password: {
                    required: function(element) {
                       return $('#password').val().trim().length > 0;
                    },
                    minlength: 6,
                    strongPassword: {
                        depends: function(element) {
                            return $('#password').val().trim().length > 0;
                        }
                    }
                },
             fname: "required",
             lname: "required",
             confirm_password: {
                    required: function(element) {
                       return $('#password').val().trim().length > 0;
                    },
                    equalTo: "#password"
            },
             mobileNo: {
                    required: true,
                    minlength: 10,
                    maxlength: 12
            },
            countryCode: {
                    required: true,
            }
        },
        messages: {
             fname: "Please enter your first name",
             lname: "Please enter your last name",

            email: {
                required: "Please enter your email address",
                email: "Please enter a valid email address",
                remote: "Email already exists"
            },
             password: {
                    required: "Please enter a password",
                    minlength: "Your password must be at least 6 characters long",
                    strongPassword: "Your password must contain at least one lowercase letter, one uppercase letter, and one digit"
            },
             confirm_password: {
                    required: "Please confirm your password",
                    equalTo: "Passwords do not match"
                },
            mobileNo: {
                required: "Please enter your mobile number",
                minlength: "Mobile number must be at least 10 characters long",
                maxlength: "Mobile number can't be longer than 12 characters"
            },
            countryCode: {
                required: "Please select country code",
            }
        },
        errorPlacement: function(error, element) {
           error.insertAfter(element).css('color', 'red');
        },
        submitHandler: function(form)
        {
            form.submit();
        }
    });

    function showAddAddressesContent()
    {
        $('#content2').tab('show');
    }

    var initialEmail = $('#email').val().trim();
    $('#user_edit_form').on('input', '#email', function() {
        var newEmail = $(this).val().trim();
         if (newEmail !== initialEmail) {
            $('#email').rules('add', {
                remote: {
                    url: baseUrl + "check-email",
                    type: "post",
                    data: {
                        email: function() {
                            return $('#email').val().trim();
                        }
                    }
                }
            });
        }
        else {
            $('#email').rules('remove', 'remote');
        } 
    });
});