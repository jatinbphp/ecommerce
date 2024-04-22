<div id="main-wrapper">
    <div class="gray py-3">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url(''); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url('profile-info'); ?>">My Account</a></li>
                            <li class="breadcrumb-item"><a href="#"><?php echo $title; ?></a></li>
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
                <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                    <form action="<?php echo site_url('profile-update-data/' . $userAddresses['id']); ?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12 col-lg-12 col-xl-12 col-md-12 mb-3">
                                <h4 class="ft-medium fs-lg">Edit Address</h4>
                            </div>
                        </div>
                        <?php $this->load->view('front/myAccount/address/form'); ?>
                        <button type="submit" class="btn btn-dark full-width">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
