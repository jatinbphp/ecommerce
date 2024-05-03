<?php if(isset($products) && !empty($products)): ?>
    <?php foreach($products as $key => $value): ?>
        <?php if(isset($viewType) && $viewType == 'filter'): ?>
            <div class="col-xl-4 col-lg-4 col-md-6 col-6 filters">
        <?php else: ?>
            <div class="col-xl-3 col-lg-4 col-md-6 col-6">
       <?php endif; ?>
            <?php $this->load->view('front/Products/product', array('value' => $value));  ?>
        </div>
    <?php endforeach ?>
 <?php else: ?>
    <div class="col-md-12">
        <p class="text-center">No records found.</p>
    </div>
<?php endif ?>