<ul class="nav nav-tabs" id="myTabs">
    <li class="nav-item">
        <a class="nav-link product-info  <?php if(!isset($nextTab)) echo 'active'; ?> product-tabs" id="tab1" data-type="product-info" data-toggle="tab" href="#product-info">General Information</a>
    </li>
    <li class="nav-item">
        <a class="nav-link product-image product-tabs <?php if(isset($nextTab) && $nextTab == 'product-image') echo 'active'; ?> <?php if(!isset($product_data)) echo 'disabled'; ?>" id="tab2" data-type="product-image" data-toggle="tab" href="#product-image">Product Images</a>
    </li>
    <li class="nav-item">
        <a class="nav-link product-options product-tabs <?php if(isset($nextTab) && $nextTab == 'product-options') echo 'active' ?>  <?php if(!isset($product_data)) echo 'disabled'; ?>" id="tab3" data-type="product-options" data-toggle="tab" href="#product-options">Options</a>
    </li>
</ul>
<style type="text/css">
    .nav-tabs .active {color: #007bff !important;}
</style>
<div class="tab-content mt-2">
    <div class="row tab-pane fade <?php if(!isset($nextTab)) echo 'show active'; ?> tab-product-data" id="product-info">
        <?php $this->load->view('admin/Product/Tabs/productInfo'); ?>
    </div>
    <div class="row tab-pane fade  <?php if(isset($nextTab) && $nextTab == 'product-image') echo 'show active'; ?> tab-product-data" id="product-image">
        <?php $this->load->view('admin/Product/Tabs/productImage'); ?>
    </div>
    <div class="row tab-pane fade <?php if(isset($nextTab) && $nextTab == 'product-options') echo 'show active'; ?> tab-product-data" id="product-options">
        <?php $this->load->view('admin/Product/Tabs/productOptions'); ?>
    </div>
</div>
