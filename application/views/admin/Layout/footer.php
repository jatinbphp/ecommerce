	<footer class="main-footer">
		All Rights
	</footer>
</div>
<!-- DataTables -->
<script src="<?php echo base_url('public/assets/admin/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/dist/js/jquery.validate.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('public/assets/admin/dist/js/adminlte.js'); ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/chart.js/Chart.min.js'); ?>"></script>
<script src="<?php echo base_url('public/assets/admin/dist/js/demo.js'); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/ladda/spin.min.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/ladda/ladda.min.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/summernote/summernote.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/dist/js/adminJqueryValidation.js?time='.time()) ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/select2/select2.full.min.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/moment/moment.min.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/bootstrap-switch/js/bootstrap-switch.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function getData(){
        var tockenName = getTockenName();
        var tockenValue = getTockenValue();
        var dataObj = {};
        dataObj[tockenName] = tockenValue;
        return dataObj;
    }
$(document).ready(function() {
    var categories = $('#CategoriesTable').on('preXhr.dt', function (e, settings, data) {
        $.extend(data, getData());
    }).DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:baseUrl+"admin/categories/fetch_categories",
            type:"POST",
            data:getData(),
            complete: function() {
                updateCsrfToken();
            }
        },
        "columnDefs": [{
            "targets":[0,1,2,3,4],
            "orderable": false
        }]
    });

    var users = $('#usersTable').on('preXhr.dt', function (e, settings, data) {
        $.extend(data, getData());
    }).DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:baseUrl+"admin/users/fetch_users",
            type:"POST",
            data:getData(),
            complete: function() {
                updateCsrfToken();
            }
        },
        "columnDefs": [{
            "targets":[5,6],
            "orderable": false
        }]
    });

    //users report
    var usersreport = $('#usersReportTable').on('preXhr.dt', function (e, settings, data) {
        $.extend(data, getData());
    }).DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:baseUrl+"admin/reports/fetch_user_report",
            type:"POST",
            data: function (d) {
                var formDataArray = $('#report-filter-Form').find(':input:not(select[multiple])').serializeArray();
                var formData = {};
                $.each(formDataArray, function(i, field){
                    formData[field.name] = field.value;
                });
                d = $.extend(d, formData);
    
                return d;
            },
            complete: function() {
                updateCsrfToken();
            }
        },
        "drawCallback": function (settings) {
            var api = this.api();
            var pageInfo = api.page.info();
            var start = pageInfo.recordsTotal > 0 ? pageInfo.start + 1 : 0;
            var end = pageInfo.recordsTotal > 0 ? pageInfo.end : 0;
            var totalEntries = pageInfo.recordsTotal > 0 ? pageInfo.recordsDisplay : 0;

            if (totalEntries === 0) {
                start = end = 0;
            }

            $(this).closest('.dataTables_wrapper').find('.dataTables_info').html(
                'Showing ' + start + ' to ' + end +
                ' of ' + totalEntries + ' entries'
            );
        },
        "columnDefs": [{
            "targets":[5],
            "orderable": false
        }]
    });
    
    //sales report
    var salesreport = $('#salesReportTable').on('preXhr.dt', function (e, settings, data) {
        $.extend(data, getData());
    }).DataTable({
        "processing": true,
        "serverSide": true,
        "order": [[0, "desc"]],
        "ajax":{
            url:baseUrl+"admin/reports/fetch_sales_report",
            type:"POST",
            data: function (d) {
                var formDataArray = $('#report-filter-Form').find(':input:not(select[multiple])').serializeArray();
                var formData = {};
                $.each(formDataArray, function(i, field){
                    formData[field.name] = field.value;
                });
                d = $.extend(d, formData);

                return d;
            },
            complete: function() {
                updateCsrfToken();
            }
        },
        "drawCallback": function (settings) {
            var api = this.api();
            var pageInfo = api.page.info();
            var start = pageInfo.recordsTotal > 0 ? pageInfo.start + 1 : 0;
            var end = pageInfo.recordsTotal > 0 ? pageInfo.end : 0;
            var totalEntries = pageInfo.recordsTotal > 0 ? pageInfo.recordsDisplay : 0;

            if (totalEntries === 0) {
                start = end = 0;
            }
            
            $(this).closest('.dataTables_wrapper').find('.dataTables_info').html(
                'Showing ' + start + ' to ' + end +
                ' of ' + totalEntries + ' entries'
            );
        },
        "columnDefs": [{
            "targets":[4],
            "orderable": false
        }]
    });

    var banners = $('#banerTable').on('preXhr.dt', function (e, settings, data) {
        $.extend(data, getData());
    }).DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:baseUrl+"admin/banners/fetch_banners",
            type:"POST",
            data:getData(),
            complete: function() {
                updateCsrfToken();
            }
        },
        "columnDefs": [{
            "targets":[5],
            "orderable": false
        }]
    });

    var contentTable = $('#contentTable').on('preXhr.dt', function (e, settings, data) {
        $.extend(data, getData());
    }).DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:baseUrl+"admin/contemt-management/fetch_content",
            type:"POST",
            data:getData(),
            complete: function() {
                updateCsrfToken();
            }
        },
        "columnDefs": [{
            "targets":[2],
            "orderable": false,
            "searchable": false,
        }]
    });

    var contactUs = $('#contactUsTable').on('preXhr.dt', function (e, settings, data) {
        $.extend(data, getData());
    }).DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:baseUrl+"admin/contact-us/fetch_contactus",
            type:"POST",
            data:getData(),
            complete: function() {
                updateCsrfToken();
            }
        },
        "columnDefs": [{
            "targets":[5],
            "orderable": false,
            "searchable": false,
        }]
    });

    var products = $('#productsTable').on('preXhr.dt', function (e, settings, data) {
        $.extend(data, getData());
    }).DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:baseUrl+"admin/products/fetch_products",
            type:"POST",
            data:getData(),
            complete: function() {
                updateCsrfToken();
            }
        },
        "columnDefs": [{
            "targets":[4,6],
            "orderable": false
        }]
    });

    var subscriptionPlan = $('#subscriptionPlanTable').on('preXhr.dt', function (e, settings, data) {
        $.extend(data, getData());
    }).DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:baseUrl+"admin/subscription-plan/fetch_subscription_plan",
            type:"POST",
            data:getData(),
            complete: function() {
                updateCsrfToken();
            }
        },
        "columnDefs": [{
            "targets":[4],
            "orderable": false
        }]
    });

    var productId = $('#reviewsTable').attr('data-product-id'); 
    var reviews = $('#reviewsTable').on('preXhr.dt', function (e, settings, data) {
        $.extend(data, getData());
    }).DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:baseUrl+"admin/products/fetch_reviews/"+productId,
            type:"POST",
            data:getData(),
            complete: function() {
                updateCsrfToken();
            }
        },
        "columnDefs": [{
            "targets":[0],
            "orderable": false
        }]
    });

    var orders_table = $('#ordersDasboardTable').on('preXhr.dt', function (e, settings, data) {
        $.extend(data, getData());
    }).DataTable({
        'processing': true,
        'serverSide': false,
        "ajax":{
            url:baseUrl+"admin/dashboard/fetch-orders",
            type:"POST",
            data:getData(),
            complete: function() {
                updateCsrfToken();
            }
        },
        
        'paging': false, // Hide pagination
        'info': false, // Hide information about number of records
        'columns': [
            { data: 'id', width: '10%', name: 'id'},
            { data: 'order_id', name: 'order_id'},
            { data: 'user_name', name: 'user_name'},
            { data: 'total_amount', name: 'total_amount', class: 'text-right'},
            { data: 'status', "width": "12%", name: 'status'},
            { data: 'created_at', "width": "15%", name: 'created_at'},
            { data: 'action', "width": "5%", name: 'action'},
        ],
        "columnDefs": [
            { "orderable": false, "targets": "_all" } // Disable sorting only for the first column
        ],
        "order": []
    });

    var orders = $('#ordersTable').on('preXhr.dt', function (e, settings, data) {
        $.extend(data, getData());
    }).DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:baseUrl+"admin/orders/fetchOrders",
            type:"POST",
            data:getData(),
            complete: function() {
                updateCsrfToken();
            }
        },
        "columnDefs": [{
            "targets":[0,1,2,3,4,5,6],
            "orderable": false
        }]
    });

    //Admin Delete
    $("#CategoriesTable, #banerTable, #usersTable, #contactUsTable, #productsTable, #subscriptionPlanTable").on('click', '.deleteRecord', function(event) {
        event.preventDefault();
        var id = $(this).attr("data-id");
        var controller = $(this).attr("data-controller");
        var title = $(this).attr("data-title");
        var tockenName = getTockenName();
        var tockenValue = getTockenValue();
        var dataObj = {};
        dataObj[tockenName] = tockenValue;
        
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
                var responceData = {};
                $.ajax({
                    url: controller+"/delete/" + id,
                    type: "POST",
                    data:dataObj,
                    success: function(data){
                        responceData = data;     
                        swal("Deleted", "Your data successfully deleted!", "success");
                    }
                }).always(function (dataOrjqXHR, textStatus, jqXHRorErrorThrown) {
                    fetch(baseUrl+ 'get-tocken', {
                        method: 'GET',
                    }).then(function(result) {
                        result.json().then(function(data) {
                            $('input[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').val(data.csrf_token_value);
                            $('meta[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').attr('content', data.csrf_token_value);
                            if(controller == 'users'){
                                users.row('.selected').remove().draw(false);
                            } else if(controller == 'banners'){
                                banners.row('.selected').remove().draw(false);
                            } else if(controller == 'categories'){
                                if(responceData.success == 0){
                                    swal("Warning", responceData.message, "warning");
                                    return;
                                }
                                categories.row('.selected').remove().draw(false);
                            } else if(controller == 'contact-us'){
                                contactUs.row('.selected').remove().draw(false);
                            } else if(controller == 'products'){
                                products.row('.selected').remove().draw(false);
                            } else if(controller == 'subscription-plan'){
                                subscriptionPlan.row('.selected').remove().draw(false);
                            }
                        })
                    });
                });
            } else {
                swal("Cancelled", "Your Data is Safe.", "error");
            }
        });
    });

    $("#CategoriesTable, #usersTable, #banerTable, #banerTable, #productsTable, #subscriptionPlanTable").on('click', '.assign_unassign', function(event) {
        event.preventDefault();
        var url = $(this).attr('data-url');
        var id = $(this).attr("data-id");
        var type = $(this).attr("data-type");
        var table_name = $(this).attr("data-table_name");
        var tockenName = getTockenName();
        var tockenValue = getTockenValue();
        var dataObj = {
            'id': id,
            'type': type,
            'table_name': table_name,
        };
        dataObj[tockenName] = tockenValue;

        var l = Ladda.create(this);
        l.start();
        $.ajax({
            url: url,
            type: "post",
            data: dataObj,
            success: function(data){
                l.stop();
                if(type=='unassign'){
                    $('#assign_remove_'+id).hide();
                    $('#assign_add_'+id).show();
                } else {
                    $('#assign_remove_'+id).show();
                    $('#assign_add_'+id).hide();
                }
            }
        }).always(function (dataOrjqXHR, textStatus, jqXHRorErrorThrown) {
            updateCsrfToken();
        });
    });

    $('.delete-address').on('click', function() {
        var addressId = $(this).data('address-id');
        var addressForm = $(this).closest('.user-addresses');
        var tockenName = getTockenName();
        var tockenValue = getTockenValue();
        var dataObj = { address_id: addressId};
        dataObj[tockenName] = tockenValue;

        swal({
            title: "Are you sure?",
            text: "You want to delete address?",
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
                    type: 'POST',
                    url: usrDelAddrUrl, 
                    data: dataObj,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            addressForm.remove();
                            swal("Deleted", "Your data successfully deleted!", "success");
                        }
                    }
                }).always(function (dataOrjqXHR, textStatus, jqXHRorErrorThrown) {
                    updateCsrfToken();
                });
            } else {
                swal("Cancelled", "Your Data is Safe.", "error");
            }
        });
    });

    $('#sku').keyup(function() {
        var sku = $(this).val();
        var url = $(this).attr('data-check-url');
        $.ajax({
            url: url,
            type: 'GET',
            data: {sku: sku},
            dataType: 'json',
            success: function(response) {
                if (response.unique) {
                    $('#skuMessage').html('<span style="color: green;">SKU is available.</span>');
                    $('#productCreate').prop('disabled', false);
                } else {
                    $('#skuMessage').html('<span style="color: red;">SKU already exists.</span>');
                    $('#productCreate').prop('disabled', true);
                }
            }
        }).always(function (dataOrjqXHR, textStatus, jqXHRorErrorThrown) {
            updateCsrfToken();
        });
    });

    $('#ordersTable tbody').on('change', '.orderStatus', function (event) {
        event.preventDefault();
        var orderId = $(this).attr('data-id');
        var status = $(this).val();
        var tockenName = getTockenName();
        var tockenValue = getTockenValue();
        var dataObj = { 'id': orderId, 'status': status };
        dataObj[tockenName] = tockenValue;
        swal({
            title: "Are you sure?",
            text: "To update status of this order",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#17a2b8',
            confirmButtonText: 'Yes, Sure',
            cancelButtonText: "No, cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: baseUrl+'admin/orders/update-status',
                    type: "post",
                    data: dataObj,
                    success: function(data){
                        if(data.status == 1){
                            swal("Success", "Order status is updated", "success");
                        } else {
                            swal("Error", "Something is wrong!", "error");
                        }

                        if(status!='pending'){
                            $("#status"+orderId).prop("disabled", true);
                        }                            
                    }
                }).always(function (dataOrjqXHR, textStatus, jqXHRorErrorThrown) {
                    updateCsrfToken();
                });
            } else {
                swal("Cancelled", "Your data is safe!", "error");
            }
        });
    });

    $('#clear-filter').click(function() {
        var dataType = $(this).data('type');
        $('#report-filter-Form')[0].reset();
        $(".select2").val("").trigger("change");
        if(dataType=='user'){
            usersreport.ajax.reload(null, false);
        }else{
            salesreport.ajax.reload(null, false);
        }
    });

    $('#apply-filter').click(function() {
        var dataType = $(this).data('type');
        if(dataType=='user'){
            usersreport.ajax.reload(null, false);
        }else{
            salesreport.ajax.reload(null, false);
        }
    });
});
</script>

<script type="text/javascript">
	function AjaxUploadImage(obj,id){
        var file = obj.files[0];
        var imagefile = file.type;
    
        var match = ["image/jpeg", "image/png", "image/jpg", 'image/webp'];
        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]) || (imagefile == match[3])))
        {
            $('#previewing'+URL).attr('src', 'noimage.png');
            alert("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
            return false;
        } else{
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(obj.files[0]);
        }

        function imageIsLoaded(e){
            $('#DisplayImage').css("display", "block");
            $('#DisplayImage').css("margin-top", "1.5%");
            $('#DisplayImage').attr('src', e.target.result);
            $('#DisplayImage').attr('width', '150');
        }
    }

    $(".description").each(function() {
            var textarea = $(this);
            textarea.summernote({
                height: 250,
                placeholder: textarea.attr('placeholder'),
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize', 'height']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['table','picture','link','map','minidiag']],
                    ['misc', ['codeview']],
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        for (var i = 0; i < files.length; i++)
                            upload_image(files[i], this);
                    }
                },
                onInit: function() {
                    var placeholderText = textarea.attr('placeholder');
                    placeholderText = placeholderText.replace(/\n/g, "<br>");
                    textarea.summernote('option', 'placeholder', placeholderText);
                },
                onChange: function(contents) {
                    if (contents.trim() === '') {
                        var placeholderText = textarea.attr('placeholder');
                        placeholderText = placeholderText.replace(/\n/g, "<br>");
                        textarea.summernote('option', 'placeholder', placeholderText);
                    }
                }
            });
        });
      
        $('#daterange').daterangepicker({
            opens: 'left',
            locale: {
                format: 'YYYY/MM/DD'
            },
            autoUpdateInput: false
        });

        $('#daterange').on('apply.daterangepicker', function(event, picker) {
            $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
        });

        $("input[data-bootstrap-switch]").each(function(){
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

</script>
<script type="text/javascript">
	$(function () {
		$('.select2').select2();
         $('.my-colorpicker2').colorpicker()

        $(document).on('colorpickerChange', '.my-colorpicker2', function(event) {
            event.preventDefault();
            var id = $(this).attr("data-id");
            $('.my-colorpicker2 .fa-square_'+id).css('color', event.color.toString());
        })
	});
</script>
</body>
</html>
