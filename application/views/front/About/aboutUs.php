<?php $this->load->view('Breadcrumb',['current' => 'About Us']); ?>
<section class="middle">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="abt_caption">
                	<?php echo (isset($aboutUsData['description'])) ? $aboutUsData['description'] : ''; ?>
                </div>
            </div>
        </div>
    </div>
</section>
