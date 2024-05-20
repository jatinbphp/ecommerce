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
                    <?php $this->load->view('admin/SessionMessages'); ?>
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo $form_title; ?></h3>
                        </div>
                        <div class="card-body">
                            <?php echo form_open_multipart("admin/subscription-plan/send-mail/$subsctiptionId", ['id' => 'subscriptionTemplate']); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group <?php echo form_error('title') ? 'has-error' : ''; ?>">
                                            <?php echo form_label('Subject: <span class="text-danger">*</span>', 'subject', ['class' => 'control-label']); ?>

                                            <?php echo form_input(['name' => 'subject', 'id' => 'subject', 'class' => 'form-control', 'placeholder' => 'Enter Subject']); ?>

                                            <?php echo form_error('subject', '<p class="text-danger">', '</p>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group <?php echo form_error('content') ? 'has-error' : ''; ?>">
                                            <?php echo form_label('Content: <span class="text-danger">*</span>', 'content'); ?>
                                            <?php echo form_textarea('content', '','class="form-control description" id="content" placeholder="Enter Content"'); ?>
                                            <?php echo form_error('content', '<p class="text-danger">', '</p>'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="<?php echo base_url('admin/subscription-plan') ?>" class="btn btn-sm btn-default">Back</a>
                                    <?php
                                        echo form_submit([
                                            'name' => 'submit',
                                            'class' => 'btn btn-sm btn-info float-right',
                                            'value' => 'Send Mail'
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
     $("#subscriptionPlan").addClass('active');
});
</script>