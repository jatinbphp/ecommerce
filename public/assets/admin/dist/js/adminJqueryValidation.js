$(document).ready(function() {
    $('#usersTable').DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:"fetch_users",
            type:"POST"
        },
        "columnDefs": [{
            "targets":[4,5],
            "orderable": false
        }]
    });
});