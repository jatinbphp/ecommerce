
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-2">
                    <h5>Add Addresses
                            <?php echo form_button(array('type' => 'button', 'class' => 'btn btn-info btn-sm', 'id' => 'addressBtn', 'style' => 'float: right;'), '<i class="fa fa-plus"></i> Add New'); ?>
                    </h5>
                </div>
            </div>

            <!-- existing address -->
            <?php foreach ($userAddress as $key => $val): ?>
                <div class="card user-addresses" id="address_<?php echo $key; ?>">
                    <div class="row p-2">
                        <div class="col-md-12 text-right">
                            <?php echo form_button(array('type' => 'button', 'class' => 'btn btn-danger delete-address', 'data-address-id' => $val['id']), '<i class="fa fa-trash"></i>'); ?>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php echo form_label('Title :', 'title_'.$key, array('class' => 'control-label')); ?>
                                <?php echo form_input(array('class' => 'form-control', 'placeholder' => 'Enter Title', 'id' => 'title_'.$key, 'name' => 'addresses[existing]['.$val['id'].'][title]', 'type' => 'text', 'value' => $val['title'])); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('First Name :', 'first_name_'.$key, array('class' => 'control-label')); ?>
                                <span class="text-red">*</span>
                                <?php echo form_input(array('class' => 'form-control chk-required', 'placeholder' => 'Enter First Name', 'id' => 'first_name_'.$key, 'name' => 'addresses[existing]['.$val['id'].'][first_name]', 'type' => 'text', 'value' => $val['first_name'])); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Last Name :', 'last_name_'.$key, array('class' => 'control-label')); ?>
                                <span class="text-red">*</span>
                                <?php echo form_input(array('class' => 'form-control chk-required', 'placeholder' => 'Enter Last Name', 'id' => 'last_name_'.$key, 'name' => 'addresses[existing]['.$val['id'].'][last_name]', 'type' => 'text', 'value' => $val['last_name'])); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Company :', 'company_'.$key, array('class' => 'control-label')); ?>
                                <?php echo form_input(array('class' => 'form-control', 'placeholder' => 'Enter Company', 'id' => 'company_'.$key, 'name' => 'addresses[existing]['.$val['id'].'][company]', 'type' => 'text', 'value' => $val['company'])); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Mobile No :', 'mobile_phone_'.$key, array('class' => 'control-label')); ?>
                                <span class="text-red">*</span>
                                <?php echo form_input(array('class' => 'form-control chk-required', 'placeholder' => 'Enter Mobile No', 'id' => 'mobile_phone_'.$key, 'name' => 'addresses[existing]['.$val['id'].'][mobile_phone]', 'type' => 'tel', 'value' => $val['mobile_phone'])); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php echo form_label('Address :', 'address_line1_'.$key, array('class' => 'control-label')); ?>
                                <span class="text-red">*</span>
                                <?php echo form_textarea(array('class' => 'form-control chk-required', 'placeholder' => 'Enter Address', 'id' => 'address_line1_'.$key, 'rows' => '2', 'name' => 'addresses[existing]['.$val['id'].'][address_line1]', 'cols' => '50'), $val['address_line1']); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php echo form_label('Address (Line 2) :', 'address_line2_'.$key, array('class' => 'control-label')); ?>
                                <?php echo form_textarea(array('class' => 'form-control', 'placeholder' => 'Enter Address Line 2', 'id' => 'address_line2_'.$key, 'rows' => '2', 'name' => 'addresses[existing]['.$val['id'].'][address_line2]', 'cols' => '50'), $val['address_line2']); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('ZIP / Pincode :', 'pincode_'.$key, array('class' => 'control-label')); ?>
                                <span class="text-red">*</span>
                                <?php echo form_input(array('class' => 'form-control chk-required', 'placeholder' => 'Enter ZIP / Pincode', 'id' => 'pincode_'.$key, 'name' => 'addresses[existing]['.$val['id'].'][pincode]', 'type' => 'text', 'value' => $val['pincode'])); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Select Country :', 'country_'.$key, array('class' => 'control-label')); ?><span class="text-red">*</span>
                                <br>
                                <?php echo form_dropdown('addresses[existing]['.$val['id'].'][country]', ($countries ?? ['' => 'No Data Available']), isset($val['country']) ? $val['country'] : '', ['class' => 'form-control select2', 'id' => "country_$key", 'style' => 'width:100%']); ?>
                                <?php echo form_error('country_id', '<p class="text-danger">', '</p>'); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('State :', 'state_'.$key, array('class' => 'control-label')); ?>
                                <span class="text-red">*</span>
                                <?php echo form_input(array('class' => 'form-control chk-required', 'placeholder' => 'Enter State', 'id' => 'state_'.$key, 'name' => 'addresses[existing]['.$val['id'].'][state]', 'type' => 'text', 'value' => $val['state'])); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('City / Town :', 'city_'.$key, array('class' => 'control-label')); ?>
                                <span class="text-red">*</span>
                                <?php echo form_input(array('class' => 'form-control chk-required', 'placeholder' => 'Enter City / Town', 'id' => 'city_'.$key, 'name' => 'addresses[existing]['.$val['id'].'][city]', 'type' => 'text', 'value' => $val['city'])); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php echo form_label('Additional Information :', 'additional_information_'.$key, array('class' => 'control-label')); ?>
                                <?php echo form_textarea(array('class' => 'form-control', 'placeholder' => 'Enter Additional Information', 'id' => 'additional_information_'.$key, 'rows' => '2', 'name' => 'addresses[existing]['.$val['id'].'][additional_information]', 'cols' => '50'), $val['additional_information']); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div id="extraAddress"></div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var addressCounter = <?php echo count($userAddress); ?>;
    var usrDelAddrUrl = "<?php  echo base_url('admin/user/deleteAddress'); ?>";
</script>
