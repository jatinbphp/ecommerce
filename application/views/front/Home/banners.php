<?php if(isset($banner_data) && $banner_data): ?>
    <div class="home-slider margin-bottom-0">
        <?php foreach ($banner_data as $data) : ?>
            <div class="item" data-overlay="3" style="background-image: url('<?php echo base_url(($data['image']) ? $data['image'] : '') ?>');">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="home-slider-container">
                                <div class="home-slider-desc text-center">
                                    <div class="home-slider-title mb-4">
                                        <h5 class="fs-lg ft-ft-medium mb-0"><?php echo isset($data['title']) ? $data['title'] : '' ?></h5>
                                        <h1 class="mb-1 ft-bold lg-heading"><?php echo isset($data['subtitle']) ? $data['subtitle'] : '' ?></h1>
                                        <span class="trending text-light"><?php echo isset($data['description']) ? $data['description'] : '' ?></span>
                                    </div>
                                    <a href="<?php echo base_url('shop'); ?>" class="btn stretched-link light-borders ft-bold">Shop Now<i class="lni lni-arrow-right ml-2"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>