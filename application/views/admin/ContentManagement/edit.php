<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Content</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Content</li>
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
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Edit Content</h3>
                        </div>
                        <div class="card-body">
                            <?php echo form_open_multipart("admin/contemt-management/edit/{$content_data['id']}", ['id' => 'contentFormEdit']); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group <?php echo form_error('title') ? 'has-error' : ''; ?>">
                                            <?php echo form_label('Title <span class="text-danger">*</span>', 'title', ['class' => 'control-label']); ?>

                                            <?php echo form_input(['name' => 'title', 'id' => 'title', 'class' => 'form-control', 'placeholder' => 'Enter Title', 'value' => set_value('title', isset($content_data['title']) ? html_entity_decode($content_data['title']) : '')]); ?>

                                            <?php echo form_error('title', '<p class="text-danger">', '</p>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group <?php echo form_error('description') ? 'has-error' : ''; ?>">
                                            <?php echo form_label('Description <span class="text-danger">*</span>', 'description', ['class' => 'control-label']); ?>

                                            <?php echo form_label('Description <span class="text-danger">*</span>', 'description'); ?>
                                            <?php echo form_textarea('description', isset($content_data['description']) ? html_entity_decode($content_data['description']) : '', 'class="form-control description" id="description" placeholder="Enter Description"'); ?>
                                            <?php echo form_error('description', '<p class="text-danger">', '</p>'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="<?php echo base_url('admin/contemt-management') ?>" class="btn btn-sm btn-default">Back</a>
                                    <?php
                                        echo form_submit([
                                            'name' => 'submit',
                                            'class' => 'btn btn-sm btn-info float-right',
                                            'value' => 'Update'
                                        ]);
                                    ?>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<script type="text/javascript">
$(document).ready(function() {
    $("#profileTreeview").addClass('menu-open');
    $("#profileTreeview a:first").addClass('active');
    $("#profileEdit").addClass('active');
});
</script>

