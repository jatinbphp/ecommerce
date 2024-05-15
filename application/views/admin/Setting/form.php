<div class="card-body">
    <ul class="nav nav-tabs" id="myTabs">
        <li class="nav-item">
            <a class="nav-link active" id="tab1" data-toggle="tab" href="#content1">Contact Information</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab2" data-toggle="tab" href="#content2">Social Information</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab3" data-toggle="tab" href="#content3">Menu</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab4" data-toggle="tab" href="#content4">Orders</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab5" data-toggle="tab" href="#content5">Payments</a>
        </li>
    </ul>

    <style type="text/css">
        .nav-tabs .active { color: #007bff !important; }
        .select2-container--default { width: 100% !important; }
    </style>

    <?php echo form_hidden('redirects_to', site_url('admin/dashboard')); ?>

    <div class="tab-content mt-2">
        <!-- Content 1 -->
        <div class="row tab-pane fade show active" id="content1">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo form_label('Email Address:', 'email_address'); ?>
                                    <?php echo form_input(['name' => 'email_address', 'id' => 'email_address', 'class' => 'form-control', 'placeholder' => 'Enter Email Address', 'value' => isset($settings_data['email_address']) ? $settings_data['email_address'] : '']); ?>
                                    <?php echo form_error('email_address', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo form_label('Phone Number:', 'phone_number'); ?>
                                    <?php echo form_input(['name' => 'phone_number', 'id' => 'phone_number', 'class' => 'form-control', 'placeholder' => 'Enter Phone Number', 'value' => isset($settings_data['phone_number']) ? $settings_data['phone_number'] : '']); ?>
                                    <?php echo form_error('phone_number', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo form_label('Address:', 'address'); ?>
                                    <?php echo form_textarea(['name' => 'address', 'id' => 'address', 'class' => 'form-control', 'placeholder' => 'Enter Address', 'rows' => 5, 'value' => isset($settings_data['address']) ? $settings_data['address'] : '']); ?>
                                    <?php echo form_error('address', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content 2 -->
        <div class="row tab-pane fade" id="content2">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo form_label('Linkedin Url:', 'linkedin_url'); ?>
                                    <?php echo form_input(['name' => 'linkedin_url', 'id' => 'linkedin_url', 'class' => 'form-control', 'placeholder' => 'Enter Linkedin Url', 'value' => isset($settings_data['linkedin_url']) ? $settings_data['linkedin_url'] : '']); ?>
                                    <?php echo form_error('linkedin_url', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo form_label('Facebook Url:', 'facebook_url'); ?>
                                    <?php echo form_input(['name' => 'facebook_url', 'id' => 'facebook_url', 'class' => 'form-control', 'placeholder' => 'Enter Facebook Url', 'value' => isset($settings_data['facebook_url']) ? $settings_data['facebook_url'] : '']); ?>
                                    <?php echo form_error('facebook_url', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo form_label('Twitter Url:', 'twitter_url'); ?>
                                    <?php echo form_input(['name' => 'twitter_url', 'id' => 'twitter_url', 'class' => 'form-control', 'placeholder' => 'Enter Twitter Url', 'value' => isset($settings_data['twitter_url']) ? $settings_data['twitter_url'] : '']); ?>
                                    <?php echo form_error('twitter_url', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo form_label('YouTube Url:', 'youtube_url'); ?>
                                    <?php echo form_input(['name' => 'youtube_url', 'id' => 'youtube_url', 'class' => 'form-control', 'placeholder' => 'Enter YouTube Url', 'value' => isset($settings_data['youtube_url']) ? $settings_data['youtube_url'] : '']); ?>
                                    <?php echo form_error('youtube_url', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo form_label('Instagram Url:', 'instagram_url'); ?>
                                    <?php echo form_input(['name' => 'instagram_url', 'id' => 'instagram_url', 'class' => 'form-control', 'placeholder' => 'Enter Instagram Url', 'value' => isset($settings_data['instagram_url']) ? $settings_data['instagram_url'] : '']); ?>
                                    <?php echo form_error('instagram_url', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content 3 -->
        <div class="row tab-pane fade" id="content3">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group <?php echo form_error('header_menu_categories') ? 'has-error' : ''; ?>">
                                    <label for="header_menu_categories">Which Categories menu do you want to display in header menu? :</label>
                                    <select name="header_menu_categories[]" class="form-control select2 w-100" id="header_menu_categories" multiple data-placeholder="Please Select">
                                        <?php foreach ($categories_data as $id => $category): ?>
                                            <?php $selected = (in_array($id, $selected_header_categories)) ? 'selected' : ''; ?>
                                                <option value="<?php echo $id; ?>" <?php echo $selected; ?>><?php echo $category; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php echo form_error('header_menu_categories', '<span class="help-block text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group <?php echo form_error('footer_menu_categories') ? 'has-error' : ''; ?>">
                                    <label for="footer_menu_categories">Which Categories menu do you want to display in footer menu? :</label>
                                    <select name="footer_menu_categories[]" class="form-control select2 w-100" id="footer_menu_categories" multiple="true" data-placeholder="Please Select" data-maximum-selection-length="5">
                                        <?php foreach ($categories_data as $id => $category): ?>
                                            <?php $selected = (in_array($id, $selected_footer_categories)) ? 'selected' : ''; ?>
                                                <option value="<?php echo $id; ?>" <?php echo $selected; ?>><?php echo $category; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php echo form_error('footer_menu_categories', '<span class="help-block text-danger">', '</span>'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content 4 -->
        <div class="row tab-pane fade" id="content4">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo form_label('Order Cancel Period (In days):', 'order_cancel_period'); ?>
                                    <?php echo form_input(['name' => 'order_cancel_period', 'id' => 'order_cancel_period', 'class' => 'form-control', 'placeholder' => 'Enter Cancel Order Period', 'value' => isset($settings_data['order_cancel_period']) ? $settings_data['order_cancel_period'] : '']); ?>
                                    <?php echo form_error('order_cancel_period', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo form_label('Shipping Charges:', 'shipping_charges'); ?>
                                    <?php echo form_input(['name' => 'shipping_charges', 'id' => 'shipping_charges', 'class' => 'form-control', 'placeholder' => 'Enter Shipping Charges', 'value' => isset($settings_data['shipping_charges']) ? $settings_data['shipping_charges'] : '']); ?>
                                    <?php echo form_error('shipping_charges', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content 5 -->
        <div class="row tab-pane fade" id="content5">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class='col-md-12'>
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox" name="is_stripe_live_mode" class="custom-control-input" id="is_stripe_live_mode" <?php echo (isset($settings_data['is_stripe_live_mode']) && $settings_data['is_stripe_live_mode']) ? 'checked' : '' ?>>
                                        <label class="custom-control-label" for="is_stripe_live_mode">Is Stripe Live Mode</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo form_label('Testing Stripe Publishable Key:', 'stripe_publishable_key'); ?>
                                    <?php echo form_input(['name' => 'stripe_publishable_key', 'id' => 'stripe_publishable_key', 'class' => 'form-control', 'placeholder' => 'Enter Testing Stripe Publishable Key', 'value' => isset($settings_data['stripe_publishable_key']) ? $settings_data['stripe_publishable_key'] : '']); ?>
                                    <?php echo form_error('stripe_publishable_key', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo form_label('Testing Stripe Secret Key:', 'stripe_secret_key'); ?>
                                    <?php echo form_input(['name' => 'stripe_secret_key', 'id' => 'stripe_secret_key', 'class' => 'form-control', 'placeholder' => 'Enter Testing Stripe Secret Key', 'value' => isset($settings_data['stripe_secret_key']) ? $settings_data['stripe_secret_key'] : '']); ?>
                                    <?php echo form_error('stripe_secret_key', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo form_label('Live Stripe Publishable Key:', 'live_stripe_publishable_key'); ?>
                                    <?php echo form_input(['name' => 'live_stripe_publishable_key', 'id' => 'live_stripe_publishable_key', 'class' => 'form-control', 'placeholder' => 'Enter Live Stripe Publishable Key', 'value' => isset($settings_data['live_stripe_publishable_key']) ? $settings_data['live_stripe_publishable_key'] : '']); ?>
                                    <?php echo form_error('live_stripe_publishable_key', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo form_label('Live Stripe Secret Key:', 'live_stripe_secret_key'); ?>
                                    <?php echo form_input(['name' => 'live_stripe_secret_key', 'id' => 'live_stripe_secret_key', 'class' => 'form-control', 'placeholder' => 'Enter Live Stripe Secret Key', 'value' => isset($settings_data['live_stripe_secret_key']) ? $settings_data['live_stripe_secret_key'] : '']); ?>
                                    <?php echo form_error('live_stripe_secret_key', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
