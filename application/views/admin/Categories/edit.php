<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Categories</h1>
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

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Manage Categories</h3>
                        </div>
                        <?php echo form_open("admin/categories/edit/" . $categories_data['id'], ['method' => 'post', 'id' => 'categories_form']); ?>
                            <div class="card-body">
                                <?php echo form_hidden('id', isset($categories_data['id']) ? $categories_data['id'] : '') ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <?php
                                                echo form_label('Name <span class="text-danger">*</span>', 'fname');
                                                echo form_input([
                                                    'name' => 'name',
                                                    'id' => 'name',
                                                    'class' => 'form-control',
                                                    'placeholder' => 'Please Enter Category Name',
                                                    'value' => isset($categories_data['name']) ? $categories_data['name'] : '',
                                                ]);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                              <button type="submit" class="btn btn-primary">Update</button>
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