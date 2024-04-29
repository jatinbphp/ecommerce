<section class="bg-cover bckPos-topCenter" data-overlay="1" style="background:url(images/banner-1.jpg) no-repeat;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="text-left py-md-5 mt-md-3 mb-md-3">
                    <h1 class="ft-medium mb-3">Shop</h1>
                    <ul class="shop_categories_list m-0 p-0">
                        <li><a href="#" class="">Men</a></li>
                        <li><a href="#" class="">Speakers</a></li>
                        <li><a href="#" class="">Women</a></li>
                        <li><a href="#" class="">Accessories</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
            
<section class="py-3 br-bottom br-top">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Women's</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="middle">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 p-xl-0">
                <div class="search-sidebar sm-sidebar border">
                    <div class="search-sidebar-body">
                        <div class="single_search_boxed d-none d-lg-block">
                            <div class="widget-boxed-header px-3">
                                <h4 class="mt-3">Categories</h4>
                            </div>
                            <div class="widget-boxed-body">
                                <div class="side-list no-border">
                                    <div class="filter-card" id="shop-categories">
                                        <!-- <?php if(isset($categories) && !empty($categories)): ?>
                                            <?php render_categories($categories); ?> 
                                        <?php endif; ?>  -->

                                        <!-- <?php
                                            // Recursive function to render categories and subcategories
                                            function render_categories($categories, $level = 0) {
                                                foreach ($categories as $category) {
                                                    echo '<div class="single_filter_card">';
                                                    echo '<h5><a href="#category_' . $category['id'] . '" data-toggle="collapse" class="collapsed" aria-expanded="false" role="button">' . htmlspecialchars($category['name']) . '<i class="accordion-indicator ti-angle-down"></i></a></h5>';
                                                    echo '<div class="collapse" id="category_' . $category['id'] . '" data-parent="#shop-categories">';
                                                    echo '<div class="card-body">';
                                                    echo '<div class="inner_widget_link">';
                                                    echo '<ul>';

                                                    // Render current category's products count (optional)
                                                    //echo '<li><a href="#">Products Count: ' . $category['product_count'] . '</a></li>';

                                                    // Recursively render subcategories
                                                    if (isset($category['sub_category']) && !empty($category['sub_category'])) {
                                                        render_categories($category['sub_category'], $level + 1); // Recursive call
                                                    }

                                                    echo '</ul>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                }
                                            }
                                        ?>  -->

                                        <div class="single_filter_card">
                                            <h5><a href="#clothing" data-toggle="collapse" class="" aria-expanded="false" role="button">Clothing<i class="accordion-indicator ti-angle-down"></i></a></h5>
                                            <div class="collapse" id="clothing" data-parent="#shop-categories">
                                                <div class="card-body">
                                                    <div class="inner_widget_link">
                                                        <ul>
                                                            <li><a href="#">Men Suits<span>110</span></a></li>
                                                            <li><a href="#">Blouses<span>103</span></a></li>
                                                            <li><a href="#">Coat Pant<span>72</span></a></li>
                                                            <li><a href="#">T-Shirts<span>36</span></a></li>
                                                            <li><a href="#">Men Shirts<span>122</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4><a href="#pricing" data-toggle="collapse" aria-expanded="false" role="button">Pricing</a></h4>
                            </div>
                            <div class="widget-boxed-body collapse show" id="pricing" data-parent="#pricing">
                                <div class="side-list no-border mb-4">
                                    <div class="rg-slider">
                                        <input type="text" class="js-range-slider" name="my_range" value="" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if(isset($options)  && !empty($options)): ?>
                            <?php foreach($options as $optionName => $optionValue): ?>
                                <div class="single_search_boxed">
                                    <div class="widget-boxed-header">
                                        <h4><a href="#<?= $optionName ?? null ?>" data-toggle="collapse" class="collapsed" aria-expanded="false" role="button"><?= strtoupper($optionName) ?? "-" ?></a></h4>
                                    </div>
                                    <div class="widget-boxed-body collapse" id="<?= $optionName ?? null ?>" data-parent="#<?= $optionName ?? null ?>">
                                        <div class="side-list no-border">
                                            <div class="single_filter_card">
                                                <div class="card-body pt-0">
                                                    <div class="inner_widget_link">
                                                        <ul class="no-ul-list">
                                                            <?php if(!empty($optionValue)): ?>
                                                                <?php foreach($optionValue as $key => $value): ?>
                                                                    <?php if(isset($value['product_count']) && $value['product_count'] > 0): ?>
                                                                        <li>
                                                                            <input onclick="setOption(event, '<?= addslashes($optionName ?? '') ?>')" value="<?= $value['id'] ?? null ?>" id="<?= $optionName ?? '' ?>-<?= $key ?>" class="checkbox-custom option-<?= $optionName ?? '' ?>" name="<?= $optionName ?? '' ?>" type="checkbox">
                                                                            <label for="<?= $optionName ?? '' ?>-<?= $key ?>" class="checkbox-custom-label text-capitalize"><?php echo preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $value['option_value']) ? '<i class="fas fa-square" style="color: '.$value['option_value'].'"></i>' : $value['option_value']; ?><span><?= $value['product_count'] ?? "-" ?></span></label>
                                                                        </li>
                                                                    <?php endif ?>
                                                                <?php endforeach ?>
                                                            <?php endif ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="border mb-3 mfliud">
                            <div class="row align-items-center py-2 m-0">
                                <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12 d-none d-md-flex">
                                    <h6 class="mb-0">315 Items Found</h6>
                                </div>
                                <div class="col-xl-9 col-lg-8 col-md-7 col-sm-12">
                                    <div class="filter_wraps d-flex align-items-center justify-content-end m-start">
                                        <div class="single_fitres mr-2 br-right">
                                            <select class="custom-select simple">
                                                <option value="1" selected="">Default Sorting</option>
                                                <option value="2">Sort by price: Low price</option>
                                                <option value="3">Sort by price: Hight price</option>
                                                <option value="4">Sort by rating</option>
                                                <option value="5">Sort by trending</option>
                                            </select>
                                        </div>
                                        <div class="single_fitres">
                                            <a href="JavaScript:;" class="simple-button grid active mr-1"><i class="ti-layout-grid2"></i></a>
                                            <a href="JavaScript:;" class="simple-button list"><i class="ti-view-list"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center rows-products grid">
                    <!-- <div class="col-xl-4 col-lg-4 col-md-6 col-6">
                        <div class="product_grid card b-0">
                            <div class="badge bg-info text-white position-absolute ft-regular ab-left text-upper">New</div>
                            <div class="card-body p-0">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden" href="product-detail.html"><img class="card-img-top" src="images/12.jpg" alt="..."></a>
                                    <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="product-hover-overlay bg-dark d-flex align-items-center justify-content-center text-white fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                </div>
                            </div>
                            <div class="card-footer b-0 p-0 pt-2 bg-white">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="text-left">
                                        <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star"></i>
											<span class="small">(5 Reviews)</span>
										</div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn auto btn_love snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                    </div>
                                </div>
                                <div class="text-left">
                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="product-detail.html">Formal Men Lowers</a></h5>
                                    <div class="elis_rty"><span class="ft-bold text-dark fs-sm">$99 - $129</span></div>
                                    <div class="d-none">
                                    	<p class="mt-3 mb-4">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum are deleniti atque corrupti quos dolores</p>
                                    	<a href="javascript:void(0);" class="btn stretched-link borders  snackbar-addcart">Add To Cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                   
                </div>

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 text-center pt-4 pb-4">
                        <a href="#" class="btn stretched-link borders m-auto"><i class="lni lni-reload mr-2"></i>Load More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>