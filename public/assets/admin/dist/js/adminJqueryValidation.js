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

    $('#usersTable').DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{

            url:"users/fetch_users",
            type:"POST"
        },
        "columnDefs": [{
            "targets":[4,5],
            "orderable": false
        }]
    });

    $("#CategoriesTable").on('click', '.assign_unassign', function(event) {
        event.preventDefault();
        var url = $(this).attr('data-url');
        var id = $(this).attr("data-id");
        var type = $(this).attr("data-type");
        var table_name = $(this).attr("data-table_name");
        var section = $(this).attr("data-table_name");

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

                if(section=='users_table'){
                    users_table.draw(false);
                } else if(section=='products_table'){
                    products_table.draw(false);
                } else if(section=='products_table'){
                    products_table.draw(false);
                } else if(section=='options_table'){
                    options_table.draw(false);
                }
            }
        });
    });
});