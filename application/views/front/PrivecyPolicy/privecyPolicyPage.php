<?php $this->load->view('Breadcrumb',['current' => 'Privacy Policy']); ?>
<section class="middle">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-11 col-lg-12 col-md-6 col-sm-12">
                <div class="abt_caption">
                	<?php echo (isset($privecy_data['description'])) ? $privecy_data['description'] : ''; ?>
                </div>
            </div>
        </div>
    </div>
</section>