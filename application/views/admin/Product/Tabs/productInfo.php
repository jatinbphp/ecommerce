<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group <?php echo form_error('category_id') ? 'has-error' : ''; ?>">
                        <?php echo form_label('Select Category: <span class="text-danger">*</span>', 'category_id', ['class' => 'control-label']); ?>
                        <br>
                        <?php echo form_dropdown('category_id', $categories, isset($product_data['category_id']) ? $product_data['category_id'] : '', ['class' => 'form-control select2', 'id' => 'category_id']); ?>
                        <span class="category-error"></span>
                        <?php echo form_error('category_id', '<p class="text-danger">', '</p>'); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group <?php echo form_error('product_name') ? 'has-error' : ''; ?>">
                        <?php echo form_label('Product Name: <span class="text-danger">*</span>', 'product_name', ['class' => 'control-label']); ?>
                        <?php echo form_input(['name' => 'product_name', 'value' => set_value('product_name', isset($product_data['product_name']) ? $product_data['product_name'] : ''), 'class' => 'form-control', 'placeholder' => 'Enter Product Name', 'id' => 'product_name']); ?>
                        <?php echo form_error('product_name', '<p class="text-danger">', '</p>'); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group <?php echo form_error('sku') ? 'has-error' : ''; ?>">
                        <?php echo form_label('SKU: <span class="text-danger">*</span>', 'sku', ['class' => 'control-label']); ?>
                        <?php echo form_input(['name' => 'sku', 'value' => set_value('sku', isset($product_data['sku']) ? $product_data['sku'] : ''), 'class' => 'form-control', 'placeholder' => 'Enter SKU', 'id' => 'sku']); ?>
                        <?php echo form_error('sku', '<p class="text-danger">', '</p>'); ?>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group <?php echo form_error('description') ? 'has-error' : ''; ?>">
                        <?php echo form_label('Description: <span class="text-danger">*</span>', 'description', ['class' => 'control-label']); ?>
                        <?php echo form_textarea(['name' => 'description', 'value' => set_value('description', isset($product_data['description']) ? $product_data['description'] : ''), 'class' => 'form-control', 'placeholder' => 'Enter Description', 'id' => 'description', 'rows' => '4']); ?>
                        <?php echo form_error('description', '<p class="text-danger">', '</p>'); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group <?php echo form_error('type') ? 'has-error' : ''; ?>">
                        <?php echo form_label('Type: <span class="text-danger">*</span> ', 'type', ['class' => 'control-label']); ?>
                        <?php echo form_dropdown('type', (isset($type) ? $type : []), set_value('type', isset($product_data['type']) ? $product_data['type'] : ''), ['class' => 'form-control select2', 'id' => 'type']); ?>
                        <span class="type-error"></span>
                        <?php echo form_error('type', '<p class="text-danger">', '</p>'); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group <?php echo form_error('price') ? 'has-error' : ''; ?>">
                        <?php echo form_label('Price: <span class="text-danger">*</span>', 'price', ['class' => 'control-label']); ?>
                        <?php echo form_input(['name' => 'price', 'value' => set_value('price', isset($product_data['price']) ? $product_data['price'] : ''), 'class' => 'form-control', 'placeholder' => 'Enter Price', 'id' => 'price']); ?>
                        <?php echo form_error('price', '<p class="text-danger">', '</p>'); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group <?php echo form_error('status') ? 'has-error' : ''; ?>">
                        <?php echo form_label('Status: <span class="text-danger">*</span>', 'status', ['class' => 'control-label']); ?>
                        <div class="">
                            <?php foreach ($status as $key => $value): ?>
                                <label>
                                     <?php $statusData = (isset($product_data['status'])) ? $product_data['status'] : 'active';
                                        $checked = $statusData == $key ? 'checked' : '';
                                     ?>
                                     <?php echo form_radio('status', $key, $checked, 'class="flat-red"'); ?> <span style="margin-right: 10px"><?php echo $value; ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <?php echo form_error('status', '<p class="text-danger">', '</p>'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
