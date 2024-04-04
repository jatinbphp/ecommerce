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

    $("#user_create_form").validate(
    {                
        rules:
        {     
            first_name:{
                required: true
            },
            last_name:{
                required: true
            },
             email: {
                required: true,
                email: true,
                remote: {
                    url: baseUrl+"check-email",
                    type: "post"
                }
            },
            phone: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10
            },
            password: {
                required: true,
                minlength: 6,
            },
            confirm_password: {
                required: true,
                equalTo: "#password"
            }
        },
        messages:
        {
            first_name:'Please Enter First Name.',
            last_name:'Please Enter Last Name.',
            email: {
                required: 'Please Enter Email address.',
                email: 'Please Enter a Valid Email Address.',
                remote: "Email already exists",
            },
            phone: {
                required: 'Please Enter Phone Number.',
                number: 'Please Enter a Valid Phone Number.'
            },
            password: {
                required: 'Please Enter Password.',
                minlength: 'Your Password Must Be At Least 6 Characters Long.',
            },
            confirm_password: {
                required: 'Please Confirm Password.',
                equalTo: 'Passwords do not match.',
            }
        },
        submitHandler: function(form)
        {
            form.submit();
        }
    });
});