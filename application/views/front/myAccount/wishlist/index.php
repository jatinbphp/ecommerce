<div id="main-wrapper">
    <?php $this->load->view('Breadcrumb',['current' => $title, 'middle' => ['my_account' => 'profile-info']]); ?>
    <section class="middle">
        <div class="container">
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
                                                <a class="card-img-top d-block overflow-hidden" target="blank" href="<?php echo base_url('products/' . ($wishlist_item['product_details']['slug'] ?? '') . '/details') ?>">
                                                    <img class="card-img-top" src="<?php echo base_url(($wishlist_item['image'][0] ?? '')); ?>" alt="Product Image">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1">
                                                        <a target="blank" href="<?php echo base_url('products/' . ($wishlist_item['product_details']['slug'] ?? '') . '/details') ?>"><?php echo ($wishlist_item['product_details']['product_name'] ?? ''); ?></a>
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
<script type="text/javascript">
    $(document).ready(function() {
        $("#mywishlist").addClass('active');
    });
</script>

