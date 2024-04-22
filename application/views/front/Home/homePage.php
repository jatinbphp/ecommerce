<?php $this->load->view('front/Home/banners');  ?>
<section class="middle d-none">
    <div class="container">
        <div class="row no-gutters exlio_gutters">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="single_cats">
                    <a href="javaScript:;" class="cards card-overflow card-scale lg_height">
                        <div class="bg-image" style="background: url('<?php echo base_url("images/b-8.png") ?>')  no-repeat;"></div>
                        <div class="ct_body">
                            <div class="ct_body_caption left">
                                <h2 class="m-0 ft-bold lh-1 fs-md text-upper">Women Clothes</h2>
                                <span>3272 Items</span>
                            </div>
                            <div class="ct_footer left">
                                <span class="stretched-link fs-md">Browse Items <i class="ti-arrow-circle-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="single_cats">
                    <a href="javaScript:;" class="cards card-overflow card-scale md_height">
                        <div class="bg-image" style="background: url('<?php echo base_url("images/b-5.png") ?>') no-repeat;"></div>
                        <div class="ct_body">
                            <div class="ct_body_caption left">
                                <h2 class="m-0 ft-bold lh-1 fs-md text-upper">Men's Wear</h2>
                                <span>7632 Items</span>
                            </div>
                            <div class="ct_footer left">
                                <span class="stretched-link fs-md">Browse Items <i class="ti-arrow-circle-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <!-- row -->
                <div class="row no-gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="single_cats">
                            <a href="javaScript:;" class="cards card-overflow card-scale md_height">
                                <div class="bg-image" style="background: url('<?php echo base_url("images/b-3.png") ?>') no-repeat;"></div>
                                <div class="ct_body">
                                    <div class="ct_body_caption left">
                                        <h2 class="m-0 ft-bold lh-1 fs-md text-upper">Kid's Wear</h2>
                                        <span>4072 Items</span>
                                    </div>
                                    <div class="ct_footer left">
                                        <span class="stretched-link fs-md">Browse Items <i class="ti-arrow-circle-right"></i></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="single_cats">
                            <a href="javaScript:;" class="cards card-overflow card-scale lg_height">
                                <div class="bg-image" style="background: url('<?php echo base_url("images/b-7.png") ?>') no-repeat;"></div>
                                <div class="ct_body">
                                    <div class="ct_body_caption left">
                                        <h2 class="m-0 ft-bold lh-1 fs-md text-upper">Men's Jackets</h2>
                                        <span>9652 Items</span>
                                    </div>
                                    <div class="ct_footer left">
                                        <span class="stretched-link fs-md">Browse Items <i class="ti-arrow-circle-right"></i></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /row -->
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Trendy Products</h2>
                    <h3 class="ft-bold pt-3">Our Trending Products</h3>
                </div>
            </div>
        </div>
        
        <div class="row align-items-center rows-products">
            <?php if(isset($latest_products) && !empty($latest_products)): ?>
                <?php foreach($latest_products as $key => $value): ?>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                        <div class="product_grid card b-0">
                            <div class="badge bg-info text-white position-absolute ft-regular ab-left text-upper">New</div>
                            <button class="btn btn_love position-absolute ab-right snackbar-wishlist" data-id="<?php echo $value['id'] ?>"><i class="far fa-heart"></i></button> 
                            <div class="card-body p-0">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url($value['image'] ?? ''); ?>" alt="..."></a>
                                    <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                </div>
                            </div>
                            <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                <div class="text-left">
                                    <div class="text-center">
                                        <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);"><?= ucwords($value['product_name']) ?></a></h5>
                                        <div class="elis_rty"><span class="text-muted ft-medium line-through mr-2">$<?= number_format (($value['price'] * 2), 2,'.',',') ?></span><span class="ft-bold theme-cl fs-md">$<?= number_format ($value['price'], 2,'.',',') ?></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="position-relative text-center">
                    <a href="<?php echo base_url('shop'); ?>" class="btn stretched-link borders">Explore More<i class="lni lni-arrow-right ml-2"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-cover" data-overlay="5" style="background: url('<?php echo base_url("images/b-3.png") ?>') no-repeat fixed;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-9 col-md-12 col-sm-12">
                <div class="deals_wrap text-center">
                    <h4 class="ft-medium text-light">Get up to -40% Off</h4>
                    <h2 class="ft-bold text-light">Only Summer Collections</h2>
                    <p class="text-light">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.</p>
                    <div class="mt-5">
                        <a href="#" class="btn btn-white stretched-link">Start Shopping <i class="lni lni-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <ul class="nav nav-tabs b-0 d-flex align-items-center justify-content-center simple_tab_links mb-4" id="product-categories" role="tablist">
                    <?php if(isset($categories) && !empty($categories)): ?>
                        <?php foreach($categories as $key => $value): ?>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link <?= $key == 0 ? 'active' : ''; ?>" onClick="setTab(event)" href="#" id="<?= str_replace(' ', '-', strtolower($value['name'])) ?>" data-id="<?= $value['id'] ?>" aria-selected="false"><?= ucwords($value['name']) ?></a>
                            </li>
                        <?php endforeach ?>
                    <?php endif ?>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade" id="all" role="tabpanel" aria-labelledby="all-tab">
                        <div class="tab_product">
                            <div class="row rows-products">
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">Sale</div>
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/1.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Half Running Set</a></h5>
                                                    <div class="elis_rty"><span class="ft-bold fs-md text-dark">$119.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <div class="badge bg-info text-white position-absolute ft-regular ab-left text-upper">New</div>
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/2.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Formal Men Lowers</a></h5>
                                                    <div class="elis_rty"><span class="text-muted ft-medium line-through mr-2">$129.00</span><span class="ft-bold theme-cl fs-md">$79.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/3.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Half Running Suit</a></h5>
                                                    <div class="elis_rty"><span class="ft-bold fs-md text-dark">$80.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <div class="badge bg-warning text-white position-absolute ft-regular ab-left text-upper">Hot</div>
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/4.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Half Fancy Lady Dress</a></h5>
                                                    <div class="elis_rty"><span class="text-muted ft-medium line-through mr-2">$149.00</span><span class="ft-bold theme-cl fs-md">$110.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/5.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Flix Flox Jeans</a></h5>
                                                    <div class="elis_rty"><span class="text-muted ft-medium line-through mr-2">$90.00</span><span class="ft-bold theme-cl fs-md">$49.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <div class="badge bg-danger text-white position-absolute ft-regular ab-left text-upper">Hot</div>
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/6.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Fancy Salwar Suits</a></h5>
                                                    <div class="elis_rty"><span class="ft-bold fs-md text-dark">$114.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">Sale</div>
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/7.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Collot Full Dress</a></h5>
                                                    <div class="elis_rty"><span class="ft-bold theme-cl fs-md text-dark">$120.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/8.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Formal Fluex Kurti</a></h5>
                                                    <div class="elis_rty"><span class="text-muted ft-medium line-through mr-2">$149.00</span><span class="ft-bold theme-cl fs-md">$129.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show active" id="mens" role="tabpanel" aria-labelledby="mens-tab">
                        <div class="tab_product">
                            <div class="row rows-products" id="category-section">
                                
                            </div>
                        </div>
                    </div>
                    <!-- Women Content -->
                    <div class="tab-pane fade" id="women" role="tabpanel" aria-labelledby="women-tab">
                        <div class="tab_product">
                            <div class="row rows-products">
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">Sale</div>
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/1.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Half Running Set</a></h5>
                                                    <div class="elis_rty"><span class="ft-bold fs-md text-dark">$119.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <div class="badge bg-info text-white position-absolute ft-regular ab-left text-upper">New</div>
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/2.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Formal Men Lowers</a></h5>
                                                    <div class="elis_rty"><span class="text-muted ft-medium line-through mr-2">$129.00</span><span class="ft-bold theme-cl fs-md">$79.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/3.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Half Running Suit</a></h5>
                                                    <div class="elis_rty"><span class="ft-bold fs-md text-dark">$80.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <div class="badge bg-warning text-white position-absolute ft-regular ab-left text-upper">Hot</div>
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/4.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Half Fancy Lady Dress</a></h5>
                                                    <div class="elis_rty"><span class="text-muted ft-medium line-through mr-2">$149.00</span><span class="ft-bold theme-cl fs-md">$110.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/5.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Flix Flox Jeans</a></h5>
                                                    <div class="elis_rty"><span class="text-muted ft-medium line-through mr-2">$90.00</span><span class="ft-bold theme-cl fs-md">$49.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <div class="badge bg-danger text-white position-absolute ft-regular ab-left text-upper">Hot</div>
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/6.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Fancy Salwar Suits</a></h5>
                                                    <div class="elis_rty"><span class="ft-bold fs-md text-dark">$114.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">Sale</div>
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/7.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Collot Full Dress</a></h5>
                                                    <div class="elis_rty"><span class="ft-bold theme-cl fs-md text-dark">$120.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/8.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Formal Fluex Kurti</a></h5>
                                                    <div class="elis_rty"><span class="text-muted ft-medium line-through mr-2">$149.00</span><span class="ft-bold theme-cl fs-md">$129.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="kids" role="tabpanel" aria-labelledby="kids-tab">
                        <div class="tab_product">
                            <div class="row rows-products">
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">Sale</div>
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/1.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Half Running Set</a></h5>
                                                    <div class="elis_rty"><span class="ft-bold fs-md text-dark">$119.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <div class="badge bg-info text-white position-absolute ft-regular ab-left text-upper">New</div>
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/2.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Formal Men Lowers</a></h5>
                                                    <div class="elis_rty"><span class="text-muted ft-medium line-through mr-2">$129.00</span><span class="ft-bold theme-cl fs-md">$79.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/3.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Half Running Suit</a></h5>
                                                    <div class="elis_rty"><span class="ft-bold fs-md text-dark">$80.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <div class="badge bg-warning text-white position-absolute ft-regular ab-left text-upper">Hot</div>
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/4.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Half Fancy Lady Dress</a></h5>
                                                    <div class="elis_rty"><span class="text-muted ft-medium line-through mr-2">$149.00</span><span class="ft-bold theme-cl fs-md">$110.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/5.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Flix Flox Jeans</a></h5>
                                                    <div class="elis_rty"><span class="text-muted ft-medium line-through mr-2">$90.00</span><span class="ft-bold theme-cl fs-md">$49.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <div class="badge bg-danger text-white position-absolute ft-regular ab-left text-upper">Hot</div>
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/6.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Fancy Salwar Suits</a></h5>
                                                    <div class="elis_rty"><span class="ft-bold fs-md text-dark">$114.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">Sale</div>
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/7.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Collot Full Dress</a></h5>
                                                    <div class="elis_rty"><span class="ft-bold theme-cl fs-md text-dark">$120.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="javascript:void(0);"><img class="card-img-top" src="<?php echo base_url('images/8.jpg'); ?>" alt="..."></a>
                                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                            </div>
                                        </div>
                                        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                            <div class="text-left">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="javascript:void(0);">Formal Fluex Kurti</a></h5>
                                                    <div class="elis_rty"><span class="text-muted ft-medium line-through mr-2">$149.00</span><span class="ft-bold theme-cl fs-md">$129.00</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>