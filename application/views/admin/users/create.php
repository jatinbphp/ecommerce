<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                    <?php elseif($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                    <?php endif; ?>
                    <div class="card-footer">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><?php if (!isset($userData)): ?>
                                        Add User
                                    <?php else: ?>
                                        Edit User
                                    <?php endif; ?></h3>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="tab1" data-toggle="tab" href="#content1">General Information</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if(!isset($userData)) : ?> disabled <?php endif ?>" id="tab2" data-toggle="tab" href="#content2" onclick="showAddAddressesContent();">Addresses</a>
                                    </li>
                                </ul>


                                <?php 
                                    if(isset($userData)):
                                        echo form_open_multipart('admin/users/edit/'.$userData['id'], ['id' => 'user_edit_form']);
                                    else:
                                        echo form_open_multipart('admin/users/create', ['id' => 'user_create_form']);
                                    endif;

                                         ?>
                                    <?php $this->load->view('admin/users/form'); ?>
                                    <?php if(isset($userData)): ?>
                                        <?php $this->load->view('admin/users/userAddresses'); ?>
                                    <?php endif; ?>
                                    <?php echo form_submit(['class' => 'btn btn-sm btn-info float-right', 'value' => isset($userData) ? 'Update' : 'Create']); ?>
                                <?php echo form_close(); ?>
                                <div class="tab-content mt-2">
                                    <a href="<?php echo base_url('admin/users') ?>" class="btn btn-sm btn-default">Back</a>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $("#UserList").addClass('active');
    var addressCounter = 1;

    $('#addressBtn').on('click', function(){
        addressCounter = addressCounter + 1;

        $.ajax({
            url: "{{route('user.add-address')}}",
            type: "POST",
            data: {
                _token: '{{csrf_token()}}',
                'addressCounter': addressCounter,            
             },
            success: function(data){                        
                $('#extraAddress').append(data);
            }
        });
    });

    function removeAddressRow(divId, type){
        const removeRowAlert = createAddressAlert("Are you sure?", "Do want to delete this row", "warning");
        swal(removeRowAlert, function(isConfirm) {
            if (isConfirm) {
                var flag =  deleteRow(divId, type);
                if(flag){
                    swal.close();
                }
            } else{
                 swal("Cancelled", "Your data safe!", "error");
            }
        });
    }

    //remove the row
    function deleteRow(divId, type){
        $('#address_'+divId).remove();
        if ($(".user-addresses").length == 0) {
            $('#addressBtn').click();
        }
        return 1;  
    }

    function createAddressAlert(title, text, type) {
        return {
            title: title,
            text: text,
            type: type,
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: "No, cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        };
    }

    $(function() {
        $(document).on("change",".uploadFile", function(){
            var uploadFile = $(this);
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
     
            if (/^image/.test( files[0].type)){ // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file
     
                reader.onloadend = function(){ // set image data as background of div
                    //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                    uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");
                }
            }
        });
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
});
</script>