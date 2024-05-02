<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo $page_title; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('admin/SessionMessages'); ?>
                    <?php echo form_open('admin/users/create'); ?>
                    <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Add <?php echo $form_title; ?></h3>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTabs">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab1" data-toggle="tab" href="#content1">General Information</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link disabled" id="tab2" data-toggle="tab" href="#content2">Addresses</a>
                                </li>
                            </ul>
                            <div class="tab-content mt-2">
                                <div class="row tab-pane fade show active" id="content1">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <div class="form-group">
                                                                <?php
                                                                    echo form_label('First Name <span class="text-danger">*</span>', 'fname');
                                                                    echo form_input([
                                                                        'name' => 'first_name',
                                                                        'class' => 'form-control',
                                                                        'required' => 'required',
                                                                        'placeholder' => 'Enter First Name'
                                                                    ]);
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <div class="form-group">
                                                                <?php
                                                                    echo form_label('Last Name <span class="text-danger">*</span>', 'fname');
                                                                    echo form_input(array(
                                                                        'name' => 'lname',
                                                                        'id' => 'lname',
                                                                        'class' => 'form-control',
                                                                        'required' => 'required',
                                                                        'placeholder' => 'Enter Last Name'
                                                                    ));
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <?php
                                                                echo form_label('Email <span class="text-danger">*</span>', 'email');
                                                                echo form_input([
                                                                    'type' => 'email',
                                                                    'name' => 'email',
                                                                    'id' => 'email',
                                                                    'class' => 'form-control',
                                                                    'required' => 'required',
                                                                    'placeholder' => 'Enter Email'
                                                                ]);
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <?php
                                                                echo form_label('Mobile No <span class="text-danger">*</span>', 'mobileNo');
                                                                echo form_input([
                                                                    'type' => 'tel',
                                                                    'name' => 'phone',
                                                                    'class' => 'form-control',
                                                                    'required' => 'required',
                                                                    'placeholder' => 'Enter Mobile number'
                                                                ]);
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="callout callout-danger">
                                                            <h4><i class="fa fa-info"></i> Note:</h4>
                                                            <p>Leave Password and Confirm Password empty if you are not going to change the password.</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php
                                                                echo form_label('Password <span class="text-danger">*</span>', 'password');
                                                                echo form_password([
                                                                    'name' => 'password',
                                                                    'id' => 'password',
                                                                    'class' => 'form-control',
                                                                    'required' => 'required',
                                                                    'placeholder' => 'Enter your password'
                                                                ]);
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php
                                                                echo form_label('Confirm Password <span class="text-danger">*</span>', 'confirm_password');
                                                                echo form_password(array(
                                                                    'name' => 'confirm_password',
                                                                    'id' => 'confirm_password',
                                                                    'class' => 'form-control',
                                                                    'required' => 'required',
                                                                    'placeholder' => 'Confirm your password'
                                                                ));
                                                            ?>
                                                        </div>
                                                    </div>                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php
                                                                echo form_label('Image :');
                                                            ?>
                                                            <div class="">
                                                                <div class="fileError">
                                                                    <?php echo form_open_multipart('', ['id' => 'image']); ?>
                                                                        <input type="file" name="image" id="image" accept="image/*" onchange="AjaxUploadImage(this)">
                                                                    <?php echo form_close(); ?>
                                                                </div>
                                                                
                                                                <?php if(!empty($user['image']) && file_exists($user['image'])): ?>
                                                                    <img src="<?php echo base_url($user['image']); ?>" alt="User Image" style="border: 1px solid #ccc; margin-top: 5px;" width="150" id="DisplayImage">
                                                                <?php else: ?>
                                                                    <img src="<?php echo base_url('public/assets/admin/dist/img/no-image.png'); ?>" alt="User Image" style="border: 1px solid #ccc; margin-top: 5px; padding: 20px;" width="150" id="DisplayImage">
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php
                                                                echo form_label('Status :');
                                                            ?>
                                                            <div class="">
                                                                <?php foreach ($status as $key => $value): ?>
                                                                    <?php $checked = !isset($users) && $key == 'active' ? 'checked' : ''; ?>    
                                                                    <label>
                                                                        <input type="radio" name="status" value="<?php echo $key; ?>" class="flat-red" <?php echo $checked; ?>>
                                                                        <span style="margin-right: 10px"><?php echo $value; ?></span>
                                                                    </label>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $addressesCounter = 1; ?>
                                <div class="row tab-pane fade" id="content2">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12 mb-2">
                                                        <h5>Add Addresses
                                                            {!! Form::button('<i class="fa fa-plus"></i> Add New', [
                                                                'type' => 'button',
                                                                'class' => 'btn btn-info btn-sm',
                                                                'id' => 'addressBtn',
                                                                'style' => 'float: right;'
                                                            ]) !!}
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div id="extraAddress"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $("#UserList").addClass('active');
    var addressCounter = <?php echo $addressesCounter ?>;

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