<div class="row mb-2">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            <input onChange="copyBillingAddress()" id="same_as_billing" class="checkbox-custom" name="same_as_billing" type="checkbox">
            <label for="same_as_billing" class="text-dark ft-medium checkbox-custom-label">Same As Billing Address</label>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            <label for="shipping_first_name" class="text-dark ft-medium">First Name:<span style="color:red">*</span></label>
            <input type="text" name="shipping_first_name" id="shipping_first_name" class="form-control" placeholder="First Name" value="<?php echo set_value('shipping_first_name', isset($userAddresses['shipping_first_name']) ? $userAddresses['shipping_first_name'] : ''); ?>" >
            <?php echo form_error('shipping_first_name', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            <label for="shipping_last_name" class="text-dark ft-medium">Last Name:<span style="color:red">*</span></label>
            <input type="text" name="shipping_last_name" id="shipping_last_name" class="form-control" placeholder="Last Name" value="<?php echo set_value('shipping_last_name', isset($userAddresses['shipping_last_name']) ? $userAddresses['shipping_last_name'] : ''); ?>">
            <?php echo form_error('shipping_last_name', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            <label for="shipping_mobile_phone" class="text-dark ft-medium">Mobile Number:<span style="color:red">*</span></label>
            <input type="text" name="shipping_mobile_phone" id="shipping_mobile_phone" class="form-control" placeholder="Mobile Number" value="<?php echo set_value('shipping_mobile_phone', isset($userAddresses['shipping_mobile_phone']) ? $userAddresses['shipping_mobile_phone'] : ''); ?>">
            <?php echo form_error('shipping_mobile_phone', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            <label for="shipping_address_line1" class="text-dark ft-medium">Address:<span style="color:red">*</span></label>
            <input type="text" name="shipping_address_line1" id="shipping_address_line1" class="form-control" placeholder="Address" value="<?php echo set_value('shipping_address_line1', isset($userAddresses['shipping_address_line1']) ? $userAddresses['shipping_address_line1'] : ''); ?>">
            <?php echo form_error('shipping_address_line1', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            <label for="shipping_address_line2" class="text-dark ft-medium">Address (Line 2):</label>
            <input type="text" name="shipping_address_line2" id="shipping_address_line2" class="form-control" placeholder="Address (Line 2)" value="<?php echo set_value('shipping_address_line2', isset($userAddresses['shipping_address_line2']) ? $userAddresses['shipping_address_line2'] : ''); ?>">
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            <?php echo form_error('shipping_country', '<div class="text-danger">', '</div>'); ?>
            <?php echo form_label('Select Country: <span class="text-danger">*</span>', 'shipping_country', ['class' => 'control-label text-dark ft-medium']); ?>
            <br>
            <?php echo form_dropdown('shipping_country', ($countries ?? ['' => 'No Data Available']), isset($userAddresses['shipping_country']) ? $userAddresses['shipping_country'] : '', ['class' => 'form-control select2', 'id' => 'shipping_country']); ?>
            <span class="shipping_country-error"></span>
            <?php echo form_error('shipping_country_id', '<p class="text-danger">', '</p>'); ?>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            <label for="shipping_state" class="text-dark ft-medium">State:<span style="color:red">*</span></label>
            <input type="text" name="shipping_state" id="shipping_state" class="form-control" placeholder="State" value="<?php echo set_value('shipping_state', isset($userAddresses['shipping_state']) ? $userAddresses['shipping_state'] : ''); ?>">
            <?php echo form_error('shipping_state', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            <label for="shipping_city" class="text-dark ft-medium">City:<span style="color:red">*</span></label>
            <input type="text" name="shipping_city" id="shipping_city" class="form-control" placeholder="City / Town" value="<?php echo set_value('shipping_city', isset($userAddresses['shipping_city']) ? $userAddresses['shipping_city'] : ''); ?>">
            <?php echo form_error('shipping_city', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            <label for="shipping_pincode" class="text-dark ft-medium">ZIP / Pincode:<span style="color:red">*</span></label>
            <input type="text" name="shipping_pincode" id="shipping_pincode" class="form-control" placeholder="Zip / Pincode" value="<?php echo set_value('shipping_pincode', isset($userAddresses['shipping_pincode']) ? $userAddresses['shipping_pincode'] : ''); ?>">
            <?php echo form_error('shipping_pincode', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>
</div>
