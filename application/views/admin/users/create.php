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
                                            Add <?php echo $form_title; ?>
                                        <?php else: ?>
                                            Edit <?php echo $form_title; ?>

                                            <!-- address tamplate for edit clone form -->

                                            <div id="addressTemplate" style="display: none;">
                                                <div class="card user-addresses" id="address_0">
                                                    <div class="row p-2">
                                                        <div class="col-md-12 text-right">
                                                            <?php echo form_button(array(
                                                                'type' => 'button',
                                                                'class' => 'btn btn-danger delete-new-address',
                                                                'content' => '<i class="fa fa-trash"></i>'
                                                            )); ?>
                                                        </div>
                                                    </div>
                                                    <div class="row p-2">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <?php echo form_label('Title :', 'title_0', array('class' => 'control-label')); ?>
                                                                <span class="text-red">*</span>
                                                                <?php echo form_input(array(
                                                                    'name' => 'addresses[new][0][title]',
                                                                    'id' => 'title_0',
                                                                    'class' => 'form-control chk-required',
                                                                    'placeholder' => 'Enter Title'
                                                                )); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <?php echo form_label('First Name :', 'first_name_0', array('class' => 'control-label')); ?>
                                                                <span class="text-red">*</span>
                                                                <?php echo form_input(array(
                                                                    'name' => 'addresses[new][0][first_name]',
                                                                    'id' => 'first_name_0',
                                                                    'class' => 'form-control chk-required',
                                                                    'placeholder' => 'Enter First Name'
                                                                )); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <?php echo form_label('Last Name :', 'last_name_0', array('class' => 'control-label')); ?>
                                                                <span class="text-red">*</span>
                                                                <?php echo form_input(array(
                                                                    'name' => 'addresses[new][0][last_name]',
                                                                    'id' => 'last_name_0',
                                                                    'class' => 'form-control chk-required',
                                                                    'placeholder' => 'Enter Last Name'
                                                                )); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <?php echo form_label('Company :', 'company_0', array('class' => 'control-label')); ?>
                                                                <?php echo form_input(array(
                                                                    'name' => 'addresses[new][0][company]',
                                                                    'id' => 'company_0',
                                                                    'class' => 'form-control',
                                                                    'placeholder' => 'Enter Company'
                                                                )); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <?php echo form_label('Mobile No :', 'mobile_phone_0', array('class' => 'control-label')); ?>
                                                                <span class="text-red">*</span>
                                                                <?php echo form_input(array(
                                                                    'type' => 'tel',
                                                                    'name' => 'addresses[new][0][mobile_phone]',
                                                                    'id' => 'mobile_phone_0',
                                                                    'class' => 'form-control chk-required',
                                                                    'placeholder' => 'Enter Mobile No'
                                                                )); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <?php echo form_label('Address :', 'address_line1_0', array('class' => 'control-label')); ?>
                                                                <span class="text-red">*</span>
                                                                <?php echo form_textarea(array(
                                                                    'name' => 'addresses[new][0][address_line1]',
                                                                    'id' => 'address_line1_0',
                                                                    'class' => 'form-control chk-required',
                                                                    'placeholder' => 'Enter Address',
                                                                    'rows' => '2',
                                                                    'cols' => '50'                                              
                                                                )); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <?php echo form_label('Address (Line 2) :', 'address_line2_0', array('class' => 'control-label')); ?>
                                                                <?php echo form_textarea(array(
                                                                    'name' => 'addresses[new][0][address_line2]',
                                                                    'id' => 'address_line2_0',
                                                                    'class' => 'form-control',
                                                                    'placeholder' => 'Enter Address Line 2',
                                                                    'rows' => '2',
                                                                    'cols' => '50'
                                                                )); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <?php echo form_label('ZIP / Pincode :', 'pincode_0', array('class' => 'control-label')); ?>
                                                                <span class="text-red">*</span>
                                                                <?php echo form_input(array(
                                                                    'name' => 'addresses[new][0][pincode]',
                                                                    'id' => 'pincode_0',
                                                                    'class' => 'form-control chk-required',
                                                                    'placeholder' => 'Enter ZIP / Pincode'
                                                                )); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <?php echo form_label('Country :', 'country_0', array('class' => 'control-label')); ?>
                                                                <span class="text-red">*</span>
                                                                <?php echo form_input(array(
                                                                    'name' => 'addresses[new][0][country]',
                                                                    'id' => 'country_0',
                                                                    'class' => 'form-control chk-required',
                                                                    'placeholder' => 'Enter Country'
                                                                )); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <?php echo form_label('State :', 'state_0', array('class' => 'control-label')); ?>
                                                                <span class="text-red">*</span>
                                                                <?php echo form_input(array(
                                                                    'name' => 'addresses[new][0][state]',
                                                                    'id' => 'state_0',
                                                                    'class' => 'form-control chk-required',
                                                                    'placeholder' => 'Enter State'
                                                                )); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <?php echo form_label('City / Town :', 'city_0', array('class' => 'control-label')); ?>
                                                                <span class="text-red">*</span>
                                                                <?php echo form_input(array(
                                                                    'name' => 'addresses[new][0][city]',
                                                                    'id' => 'city_0',
                                                                    'class' => 'form-control chk-required',
                                                                    'placeholder' => 'Enter City / Town'
                                                                )); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <?php echo form_label('Additional Information :', 'additional_information_0', array('class' => 'control-label')); ?>
                                                                <?php echo form_textarea(array(
                                                                    'name' => 'addresses[new][0][additional_information]',
                                                                    'id' => 'additional_information_0',
                                                                    'class' => 'form-control',
                                                                    'placeholder' => 'Enter Additional Information',
                                                                    'rows' => '2',
                                                                    'cols' => '50'
                                                                )); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                <?php endif; ?></h3>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTabs">
                                    <li class="nav-item">
                                        <a class="nav-link active content1" id="tab1" data-toggle="tab" href="#content1">General Information</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link content2 <?php if(!isset($userData)) : ?> disabled <?php endif ?>" id="tab2" data-toggle="tab" href="#content2">Addresses</a>
                                    </li>
                                </ul>

                                <?php echo form_open_multipart(isset($userData) ? 'admin/users/edit/'.$userData['id'] : 'admin/users/create', ['id' => isset($userData) ? 'user_edit_form' : 'user_create_form']); ?>
                                <div class="tab-content mt-2">
                                    <!-- Content for tab 1 -->
                                    <div class="tab-pane fade show active" id="content1">
                                        <!-- General Information form fields -->
                                        <?php $this->load->view('admin/users/form'); ?>
                                        
                                    </div>
                                    <!-- Content for tab 2 -->
                                    <div class="tab-pane fade" id="content2">
                                        <?php if(isset($userData)) : ?>
                                            <?php $this->load->view('admin/users/userAddresses'); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php echo form_submit(['class' => 'btn btn-sm btn-info float-right', 'value' => isset($userData) ? 'Update' : 'Create']); ?>
                                <?php echo form_close(); ?>
                                <!-- <div class="tab-content mt-2"> -->
                                    <a href="<?php echo base_url('admin/users') ?>" class="btn btn-sm btn-default">Back</a>
                                    
                                    <!-- </div> -->
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