<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?php echo form_label('Select Parent Category :', 'fname'); ?>
                <?php echo form_dropdown('parent_category_id', $allCategories, isset($category_data['parent_category_id']) ? $category_data['parent_category_id'] : '', ['class' => 'form-control select2', 'name' => 'parent_category_id']); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php
                    echo form_label('Name : <span class="text-danger">*</span>', 'fname');
                    echo form_input(['name' => 'name', 'id' => 'name', 'class' => 'form-control', 'placeholder' => 'Please Enter Category Name', 'value' => isset($category_data['name']) ? $category_data['name'] : ''
                    ]);
                ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group <?php echo form_error('image') ? 'has-error' : ''; ?>">
                <?php echo form_label('Image : ', 'image'); ?>
                <small></small>
                <div class="image">
                    <div class="fileError">
                         <input type="file" name="image" id="image" accept="image/*" onchange="AjaxUploadImage(this)">
                    </div>

                    <?php if(!empty($category_data['image']) && file_exists($category_data['image'])): ?>
                        <img src="<?php echo base_url($category_data['image']); ?>" alt="Banner Image" style="border: 1px solid #ccc;margin-top: 5px;" width="150" id="DisplayImage">
                    <?php else: ?>
                        <img src="<?php echo base_url('images/default-image.png'); ?>" alt="Banner Image" style="border: 1px solid #ccc;margin-top: 5px;padding: 20px;" width="150" id="DisplayImage">
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group <?php echo form_error('status') ? 'has-error' : ''; ?>">
                <?php echo form_label('Status : <span class="text-danger">*</span>', 'status'); ?>
                <div class="">
                    <?php foreach ($status as $key => $value): ?>
                        <?php $statusData = (isset($category_data['status'])) ? $category_data['status'] : 'active';
                            $checked = $statusData == $key ? 'checked' : '';
                         ?>
                        <label>
                            <?php echo form_radio('status', $key, $checked, 'class="flat-red"'); ?> <span style="margin-right: 10px"><?php echo $value; ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>