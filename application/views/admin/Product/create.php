<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo $page_title ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active"><?php echo $page_title ?></li>
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
                            <h3 class="card-title">Add <?php echo $form_title ?></h3>
                        </div>
                        <?php echo form_open_multipart('', ['id' => 'productFormInfo', 'class' => 'productFormCreate']); ?>
                            <div class="card-body">
                                <?php $this->load->view('admin/Product/form'); ?>
                            </div>
                            <div class="card-footer">
                                <a href="<?php echo base_url('admin/products') ?>" class="btn btn-sm btn-default">Back</a>
                                <?php
                                    echo form_submit([
                                        'name' => 'submit',
                                        'class' => 'btn btn-sm btn-info float-right',
                                        'value' => 'Save',
                                        'id' => 'productCreate'
                                    ]);
                                ?>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $("#productlist").addClass('active');
});
</script>