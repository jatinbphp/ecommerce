<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?php echo form_label('Title <span class="text-danger">*</span>', 'title'); ?>
                <?php $title = isset($banner_data['title']) ? $banner_data['title'] : ''; ?>
                <?php echo form_input('title', set_value('title', isset($banner_data['title']) ? $banner_data['title'] : ''), 'class="form-control" placeholder="Enter Title" id="title"'); ?>
                <?php echo form_error('title', '<span class="help-block text-danger">', '</span>'); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group <?php echo form_error('subtitle') ? 'has-error' : ''; ?>">
                <?php echo form_label('Subtitle <span class="text-danger">*</span>', 'subtitle'); ?>
                <?php echo form_input('subtitle', set_value('subtitle', isset($banner_data['subtitle']) ? $banner_data['subtitle'] : ''), 'class="form-control" placeholder="Enter Subtitle" id="subtitle"'); ?>
                <?php echo form_error('subtitle', '<span class="help-block text-danger">', '</span>'); ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group <?php echo form_error('description') ? 'has-error' : ''; ?>">
                <?php echo form_label('Description <span class="text-danger">*</span>', 'description'); ?>
                <?php echo form_textarea('description', isset($banner_data['description']) ? $banner_data['description'] : '', 'class="form-control description" id="description" placeholder="Enter Description"'); ?>
                <?php echo form_error('description', '<span class="help-block text-danger">', '</span>'); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group <?php echo form_error('image') ? 'has-error' : ''; ?>">
                <?php echo form_label('Image <span class="text-danger">*</span>', 'image'); ?>
                <small></small>
                <div class="image">
                    <div class="fileError">
                         <input type="file" name="image" id="image" accept="image/*" onchange="AjaxUploadImage(this)">
                    </div>

                    <?php if(!empty($banner_data['image']) && file_exists($banner_data['image'])): ?>
                        <img src="<?php echo base_url($banner_data['image']); ?>" alt="Banner Image" style="border: 1px solid #ccc;margin-top: 5px;" width="150" id="DisplayImage">
                    <?php else: ?>
                        <img src="<?php echo base_url('public/assets/admin/dist/img/no-image.png'); ?>" alt="Banner Image" style="border: 1px solid #ccc;margin-top: 5px;padding: 20px;" width="150" id="DisplayImage">
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group <?php echo form_error('status') ? 'has-error' : ''; ?>">
                <?php echo form_label('Status <span class="text-danger">*</span>', 'status'); ?>
                <div class="">
                    <?php foreach ($status as $key => $value): ?>
                        <?php $statusData = (isset($banner_data['status'])) ? $banner_data['status'] : 'active';
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