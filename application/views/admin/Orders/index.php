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
                                Manage <?php echo $page_title; ?>
                            </h3>
                        </div>
                        <div class="card-body">
                        <table id="ordersTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order ID</th>
                                    <th>User Informations</th>
                                    <th style="width: 10%;">Total</th>
                                    <th style="width: 12%;">Status</th>
                                    <th style="width: 15%;">Date Created</th>
                                    <th style="width: 8%;">Action</th>
                                </tr>
                                </thead>
                                <tbody>                        
                                </tbody>
                                <tfoot>
                                </tfoot>
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
    $("#orderlist").addClass('active');
});
</script>

