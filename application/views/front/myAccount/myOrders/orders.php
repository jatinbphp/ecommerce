<div id="main-wrapper">
    <div class="gray py-3">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url(''); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url('profile-info'); ?>">My Account</a></li>
                            <li class="breadcrumb-item"><?php echo $title; ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <section class="middle">    
        <div class="container">
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
            <div class="row align-items-start justify-content-between">
                <?php $this->load->view('front/myAccount/common-file'); ?>
                <div class="col-12 col-md-12 col-lg-8 col-xl-8 text-center ord_list_wraps">
                    <div class="ord_list_wrap mb-4 mfliud">
                        <div class="ord_list_head gray d-flex align-items-center justify-content-between px-3 py-3">
                            <div class="olh_flex">
                                <p class="m-0 p-0"><span class="text-muted">My Orders</span></p>
                            </div>
                        </div>
                        <div class="ord_list_body text-left">
                            <table id="frontordersTable" class="table table-bordered table-striped datatable-dynamic">
                                <tbody class="ord_list_body"></tbody>
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
        $("#myorderlist").addClass('active');
    });
</script>
