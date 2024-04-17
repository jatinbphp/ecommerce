<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group <?php echo form_error('name') ? 'has-error' : ''; ?>">
                <?php echo form_label('Name <span class="text-danger">*</span>', 'name'); ?>
                <?php $name = $subscription_plan_data['name'] ?? "" ?>
                <?php echo form_input('name', set_value('name', $subscription_plan_data['name'] ?? ""), 'class="form-control" placeholder="Enter Name" id="name"'); ?>
                <?php echo form_error('name', '<span class="help-block text-danger">', '</span>'); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group <?php echo form_error('duration') ? 'has-error' : ''; ?>">
                <?php echo form_label('Duration <span class="text-danger">*</span>', 'duration'); ?>
                <?php $selected_duration = isset($subscription_plan_data['duration']) ? $subscription_plan_data['duration'] : ''; ?>
                <?php echo form_dropdown('duration', $duration, $selected_duration, 'class="form-control" id="duration"'); ?>
                <?php echo form_error('duration', '<span class="help-block text-danger">', '</span>'); ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group <?php echo form_error('description') ? 'has-error' : ''; ?>">
                <?php echo form_label('Description <span class="text-danger">*</span>', 'description'); ?>
                <?php echo form_textarea('description', isset($subscription_plan_data['description']) ? $subscription_plan_data['description'] : null, 'class="form-control description" id="description" placeholder="Enter Description"'); ?>
                <?php echo form_error('description', '<span class="help-block text-danger">', '</span>'); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group <?php echo form_error('status') ? 'has-error' : ''; ?>">
                <?php echo form_label('Status <span class="text-danger">*</span>', 'status'); ?>
                <div class="">
                    <?php foreach ($status as $key => $value): ?>
                        <?php $statusData = (isset($subscription_plan_data['status'])) ? $subscription_plan_data['status'] : 'active';
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