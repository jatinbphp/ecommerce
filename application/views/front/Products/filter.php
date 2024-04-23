<?php if(isset($products) && !empty($products)): ?>
    <?php foreach($products as $key => $value): ?>
        <?php $this->load->view('front/Products/product', array('value' => $value));  ?>
    <?php endforeach ?>
 <?php else: ?>
    <div class="row align-items-center rows-products grid">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <p class="text-center">No records found.</p>
        </div>
    </div>
<?php endif ?>