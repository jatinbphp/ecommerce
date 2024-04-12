<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Categories</li>
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
                            <h3 class="card-title">Edit Categories</h3>
                        </div>
                        <?php echo form_open_multipart("admin/categories/edit/" . $category_data['id'], ['method' => 'post', 'id' => 'categories_form_edit']); ?>
                             <?php $this->load->view('admin/Categories/form'); ?>
                            <div class="card-footer">
                                <a href="<?php echo base_url('admin/categories') ?>" class="btn btn-sm btn-default">Back</a>
                                <?php
                                    echo form_submit([
                                        'name' => 'submit',
                                        'class' => 'btn btn-sm btn-info float-right',
                                        'value' => 'Save'
                                    ]);
                                ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $("#CategoriesList").addClass('active');
});
</script>