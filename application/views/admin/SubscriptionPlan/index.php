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
                            <h3 class="card-title w-100">
                                <?php echo $page_title; ?>
                                <a href="<?php echo base_url('admin/subscription-plan/create') ?>" class="btn btn-sm btn-primary float-right"> <i class="fa fa-plus"></i> Add New</a>
                            </h3>
                        </div>
                        <div class="card-body">
                            <table id="subscriptionPlanTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 8%;">#</th>
                                    <th>Name</th>
                                    <th style="width: 10%;">Status</th>
                                    <th style="width: 14%;">Date Created</th>
                                    <th style="width: 18%;">Action</th>
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
    $("#subscriptionPlan").addClass('active');
});
</script>

