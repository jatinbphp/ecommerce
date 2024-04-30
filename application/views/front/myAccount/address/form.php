<div class="row mb-2">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            <label for="title" class="text-dark ft-medium">Title: </label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="<?php echo set_value('title', isset($userAddresses['title']) ? $userAddresses['title'] : ''); ?>">
            <?php echo form_error('title', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            <label for="first_name" class="text-dark ft-medium">First Name:<span style="color:red">*</span></label>
            <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="<?php echo set_value('first_name', isset($userAddresses['first_name']) ? $userAddresses['first_name'] : ''); ?>" >
            <?php echo form_error('first_name', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>
    
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            <label for="last_name" class="text-dark ft-medium">Last Name:<span style="color:red">*</span></label>
            <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="<?php echo set_value('last_name', isset($userAddresses['last_name']) ? $userAddresses['last_name'] : ''); ?>">
            <?php echo form_error('last_name', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>
    
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            <label for="company" class="text-dark ft-medium">Company:</label>
            <input type="text" name="company" id="company" class="form-control" placeholder="Company Name (optional)" value="<?php echo set_value('company', isset($userAddresses['company']) ? $userAddresses['company'] : ''); ?>">
            <?php echo form_error('company', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>
    
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            <label for="mobile_phone" class="text-dark ft-medium">Mobile Number:<span style="color:red">*</span></label>
            <input type="text" name="mobile_phone" id="mobile_phone" class="form-control" placeholder="Mobile Number" value="<?php echo set_value('mobile_phone', isset($userAddresses['mobile_phone']) ? $userAddresses['mobile_phone'] : ''); ?>">
            <?php echo form_error('mobile_phone', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>
    
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            <label for="address_line1" class="text-dark ft-medium">Address:<span style="color:red">*</span></label>
            <input type="text" name="address_line1" id="address_line1" class="form-control" placeholder="Address" value="<?php echo set_value('address_line1', isset($userAddresses['address_line1']) ? $userAddresses['address_line1'] : ''); ?>">
            <?php echo form_error('address_line1', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>
    
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            <label for="address_line2" class="text-dark ft-medium">Address (Line 2):</label>
            <input type="text" name="address_line2" id="address_line2" class="form-control" placeholder="Address (Line 2)" value="<?php echo set_value('address_line2', isset($userAddresses['address_line2']) ? $userAddresses['address_line2'] : ''); ?>">
        </div>
    </div>
    
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            <label for="country" class="text-dark ft-medium">Country:<span style="color:red">*</span></label>
            <input type="text" name="country" id="country" class="form-control" placeholder="Country" value="<?php echo set_value('country', isset($userAddresses['country']) ? $userAddresses['country'] : ''); ?>">
            <?php echo form_error('country', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>
    
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            <label for="state" class="text-dark ft-medium">State:<span style="color:red">*</span></label>
            <input type="text" name="state" id="state" class="form-control" placeholder="State" value="<?php echo set_value('state', isset($userAddresses['state']) ? $userAddresses['state'] : ''); ?>">
            <?php echo form_error('state', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>
    
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            <label for="city" class="text-dark ft-medium">City:<span style="color:red">*</span></label>
            <input type="text" name="city" id="city" class="form-control" placeholder="City / Town" value="<?php echo set_value('city', isset($userAddresses['city']) ? $userAddresses['city'] : ''); ?>">
            <?php echo form_error('city', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>
    
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            <label for="pincode" class="text-dark ft-medium">ZIP / Pincode:<span style="color:red">*</span></label>
            <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Zip / Pincode" value="<?php echo set_value('pincode', isset($userAddresses['pincode']) ? $userAddresses['pincode'] : ''); ?>">
            <?php echo form_error('pincode', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            <label for="additional_information" class="text-dark ft-medium">Additional Information:</label>
            <textarea name="additional_information" id="additional_information" class="form-control"><?php echo set_value('additional_information', isset($userAddresses['additional_information']) ? $userAddresses['additional_information'] : ''); ?></textarea>
        </div>
    </div>
</div>
