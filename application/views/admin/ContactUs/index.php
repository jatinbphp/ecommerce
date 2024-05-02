<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Contact Us</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Contact Us</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title w-100">
                                Manage Contact Us
                            </h3>
                        </div>
                        <div class="card-body">
                            <table id="contactUsTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th style="width:5%">#</th>
                                    <th style="width:15%">Name</th>
                                    <th style="width:15%">Email Address</th>
                                    <th>Message</th>
                                    <th style="width:15%">Date Created</th>
                                    <th style="width:10%">Action</th>
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
    $("#contactUsManagement").addClass('active');
});
</script>