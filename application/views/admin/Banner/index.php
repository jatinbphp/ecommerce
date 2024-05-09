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
            <?php $this->load->view('admin/SessionMessages'); ?>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <div class='row'>
                                <div class='col-md-6'>
                                    <h3 class="card-title w-100">
                                        Manage <?php echo $page_title; ?>
                                    </h3>
                                </div>
                                <div class='col-md-3'>
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input" id="bannerSliderCheckbox" <?php echo (isset($allow_banner_value) && $allow_banner_value) ? 'checked' : '' ?>>
                                        <label class="custom-control-label" for="bannerSliderCheckbox">Allow banners to slide manually</label>
                                    </div>
                                </div>
                                <div class='col-md-3'>
                                    <a href="<?php echo base_url('admin/banners/create') ?>" class="btn btn-sm btn-primary float-right"> <i class="fa fa-plus"></i> Add New</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="banerTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Subtitle</th>
                                    <th>Status</th>
                                    <th>Date Created</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $("#bannerlist").addClass('active');
    $('#bannerSliderCheckbox').change(function(){
        var isChecked = $(this).prop('checked');
        // Make an AJAX request to save the state in the database
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('admin/banners/update-banner-setting') ?>',
            data: { isAllow: isChecked },
            success: function(response) {
                
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
});
</script>

