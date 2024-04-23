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
                <?php if (!empty($wishlists)): ?>
                    <div class="col-12 col-md-12 col-lg-8 col-xl-8 text-center">
                        <div class="row align-items-center rows-wishlist">
                            <?php foreach ($wishlists as $wishlist_item): ?>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 product_grid">
                                    <div class="card b-0">
                                        <button class="btn btn_love position-absolute ab-right theme-cl text-danger remove-item-wishlist" data-id="<?php echo ($wishlist_item['product_details']['id'] ?? ''); ?>">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" >
                                                    <img class="card-img-top" src="<?php echo base_url(($wishlist_item['image'][0] ?? '')); ?>" alt="Product Image">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1">
                                                        <a ><?php echo ($wishlist_item['product_details']['product_name'] ?? ''); ?></a>
                                                    </h5>
                                                    <div class="elis_rty"><span class="ft-bold fs-md text-dark"><?php echo '$'. number_format(($wishlist_item['product_details']['price'] ?? 0), 2); ?></span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>    
                    </div>
                <?php else: ?>
                    <div class="col-12 col-md-12 col-lg-8 col-xl-8 text-center">
                        <div class="row align-items-center">
                            <p>Your wishlist is empty.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>
