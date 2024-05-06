<section class="bg-cover bckPos-topCenter" data-overlay="1" style="background:url(<?php echo base_url('images/banner-1.jpg') ?>) no-repeat;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="text-left py-md-5 mt-md-3 mb-md-3">
                    <h1 class="ft-medium mb-3">Shop</h1>
                    <!-- <ul class="shop_categories_list m-0 p-0">
                        <li><a href="#" class="">Men</a></li>
                        <li><a href="#" class="">Speakers</a></li>
                        <li><a href="#" class="">Women</a></li>
                        <li><a href="#" class="">Accessories</a></li>
                    </ul> -->
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
                        <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active">Shop</li>
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
                        <?php if(!isset($categoryId)): ?>    
                            <div class="single_search_boxed d-none d-lg-block">
                                <div class="widget-boxed-header px-3">
                                    <h4 class="mt-3">Categories</h4>
                                </div>
                                <div class="widget-boxed-body">
                                    <div class="side-list no-border">
                                        <div class="filter-card" id="shop-categories" data-filter-category-id="<?php echo ($categoryId ?? 0) ?>">
                                            <?php
                                                function render_categories($categories, $level = 0) {
                                                    foreach ($categories as $category) {
                                                        echo '<div class="single_filter_card category-list">';
                                                        echo '<input onclick="setOption(event, \'categoryId\')" value="'. ($category['id'] ?? 0) .'" id="filter-categoty-'.($category['id'] ?? 0).'" class="checkbox-custom option-categoryId" name="categoryId" type="checkbox">';
                                                        echo '<label for="filter-categoty-'.($category['id'] ?? 0).'" class="checkbox-custom-label text-capitalize"></label><h5><a  href= '. (count(($category['sub_category'] ?? [])) != 0 ? '"#category_' . $category['id'] . '"' : '#') .' data-toggle="collapse" class="collapsed" aria-expanded="false" role="button">' . htmlspecialchars($category['name']) . (count(($category['sub_category'] ?? [])) != 0 ? '<i class="accordion-indicator ti-angle-down"></i>' : '') . '<span class="text-right count">'.($category['product_count'] ?? 0).'</span></a></h5>';
                                                        echo '<div class="collapse" id="category_' . $category['id'] . '" data-parent="#category_' . $category['id'] . '">';
                                                        echo '<div class="card-body">';
                                                        echo '<div class="inner_widget_link">';
                                                        echo '<ul>';
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
                                            ?>
                                            <?php if(isset($categories) && !empty($categories)): ?>
                                                <?php render_categories($categories); ?> 
                                            <?php endif; ?> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div id="shop-categories" data-filter-category-id="<?php echo ($categoryId ?? 0) ?>"></div>
                        <?php endif; ?>
                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4><a href="#pricing" data-toggle="collapse" aria-expanded="false" role="button">Pricing</a></h4>
                            </div>
                            <div class="widget-boxed-body collapse show" id="pricing" data-parent="#pricing">
                                <div class="side-list no-border mb-4">
                                    <div class="rg-slider">
                                        <input type="text" onFinish="setOption(event, 'priceRange')" id='rangeSlider' class="js-range-slider" name="my_range" value="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if(isset($options) && !empty($options)): ?>
                            <?php foreach($options as $optionName => $optionValue): ?>
                                <div class="single_search_boxed">
                                    <div class="widget-boxed-header">
                                        <h4><a href="#<?= $optionName ?  preg_replace('/[^a-zA-Z0-9]+/', '_', $optionName) : null ?>" data-toggle="collapse" class="collapsed" aria-expanded="false" role="button"><?= strtoupper($optionName) ?? "-" ?></a></h4>
                                    </div>
                                    <div class="widget-boxed-body collapse" id="<?= $optionName ?  preg_replace('/[^a-zA-Z0-9]+/', '_', $optionName) : null ?>" data-parent="#<?= $optionName ?  preg_replace('/[^a-zA-Z0-9]+/', '_', $optionName) : null ?>">
                                        <div class="side-list no-border">
                                            <div class="single_filter_card">
                                                <div class="single_filter_card">
                                                    <div class="card-body pt-0">
                                                        <div class="text-left pb-0 pt-2">
                                                        <?php if(!empty($optionValue)): ?>
                                                                <?php
                                                                    $optionValuesColumn = array_column($optionValue, 'option_value');
                                                                    array_multisort($optionValuesColumn, SORT_ASC, $optionValue);
                                                                ?>
                                                                <?php foreach($optionValue as $key => $value): ?>
                                                                    <?php if(isset($value['product_count']) && $value['product_count'] > 0): ?>
                                                                        <div class="form-check form-option form-check-inline mb-2 custom-options-checkbox">
                                                                            <input onclick="setOption(event, '<?= $optionName ?  preg_replace('/[^a-zA-Z0-9]+/', '_', $optionName) : null ?>')" value="<?= $value['option_value'] ?? null ?>" id="filter-<?= $optionName ?  preg_replace('/[^a-zA-Z0-9]+/', '_', $optionName) : null ?>-<?= $key ?>" class="form-check-input option-<?= $optionName ?  preg_replace('/[^a-zA-Z0-9]+/', '_', $optionName) : null ?>" name="<?= $optionName ?? '' ?>" type="checkbox">
                                                                            <label class="form-option-label" for="filter-<?= $optionName ?  preg_replace('/[^a-zA-Z0-9]+/', '_', $optionName) : null ?>-<?= $key ?>"><?php echo preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $value['option_value']) ? '<i class="fas fa-square" style="color: '.$value['option_value'].'"></i>' : $value['option_value']; ?></label>
                                                                        </div>
                                                                    <?php endif ?>
                                                                <?php endforeach ?>
                                                            <?php endif ?>
                                                        </div>
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
                                    <h6 class="mb-0"><span id='filterCount'>0</span> Items Found</h6>
                                </div>
                                <div class="col-xl-9 col-lg-8 col-md-7 col-sm-12">
                                    <div class="filter_wraps d-flex align-items-center justify-content-end m-start">
                                        <div class="single_fitres mr-2 br-right">
                                            <select id=sort-filters class="custom-select simple">
                                                <option value="1" selected="">Default Sorting</option>
                                                <option value="2">Sort by price: Low to High</option>
                                                <option value="3">Sort by price: High to Low</option>
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
                <div class="row rows-products grid">                
                </div>
                <!-- <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 text-center pt-4 pb-4">
                        <a href="#" class="btn stretched-link borders m-auto"><i class="lni lni-reload mr-2"></i>Load More</a>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</section>
<script>
$( document ).ready(function() {
    handleFilter();
});
</script>