<?php $this->load->view('front/Home/banners');  ?>
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
                        <?php $this->load->view('front/Products/product', array('value' => $value));  ?>
                    </div>
                <?php endforeach ?>
            <?php else: ?>
                <div class="row align-items-center rows-products grid">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <p class="text-center">No records found.</p>
                    </div>
                </div>
            <?php endif ?>
        </div>

        <?php if(isset($latest_products) && !empty($latest_products)): ?>
            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="position-relative text-center">
                        <a href="<?php echo base_url('shop'); ?>" class="btn stretched-link borders">Explore More<i class="lni lni-arrow-right ml-2"></i></a>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
</section>

<!-- <section class="bg-cover d-none" data-overlay="5" style="background: url('<?php echo base_url("images/b-3.png") ?>') no-repeat fixed;">
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
</section> -->

<section class='p-0'>
    <div class="container">
    <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Top Categories</h2>
                    <h3 class="ft-bold pt-3">Our Top Categories</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <ul class="nav nav-tabs b-0 d-flex align-items-center justify-content-center simple_tab_links mb-4" id="product-categories" role="tablist">
                <?php if(isset($categories) && !empty($categories)): ?>
                        <?php foreach($categories as $key => $value): ?>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link <?= $key == 0 ? 'active' : ''; ?>" onClick="setTab(event)" href="#" id="<?= preg_replace('/[^a-zA-Z0-9]+/', '_', $value['name']) ?>" data-id="<?= $value['id'] ?>" aria-selected="false"><?= ucwords($value['name']) ?></a>
                            </li>
                        <?php endforeach ?>
                    <?php endif ?>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="mens-tab">
                        <div class="tab_product">
                            <div class="row rows-products" id="category-section">
                                <?php if(isset($categorized_products) && !empty($categorized_products)): ?>
                                    <?php foreach($categorized_products as $key => $value): ?>
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                            <?php $this->load->view('front/Products/product', array('value' => $value));  ?>
                                        </div>
                                    <?php endforeach ?>
                                <?php else: ?>
                                    <div class="row align-items-center rows-products grid">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                            <p class="text-center">No records found.</p>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>