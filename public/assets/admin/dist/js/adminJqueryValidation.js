$(document).ready(function() {

    //Admin Students Table Get
    $('#CategoriesTable').DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:"categories/fetch_categories",
            type:"POST"
        },
        "columnDefs": [{
            "targets":[4],
            "orderable": false
        }]
    });

    $("#categories-form").validate(
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
                window.location.href = controller+"/delete/" + id;
            } else {
                swal("Cancelled", yourDataSafe, "error");
            }
        });
    });

});
