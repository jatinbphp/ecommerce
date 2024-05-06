<?php if(isset($reviews) && count($reviews)): ?>
    <div class="reviews_info">
        <?php foreach($reviews as $data): ?>
            <div class="single_rev d-flex align-items-start py-3">
                <div class="single_rev_thumb" style="width: 50px;min-width: 50px;">
                    <?php if(isset($userImage) && file_exists($userImage) && isset($data['user_id']) && $this->session->userdata('userId') == $data['user_id']): ?>
                        <img src="<?php echo base_url($userImage) ?>" class="img-fluid circle" style="width: 50px;" alt="" />
                    <?php else: ?>
                        <img src="<?php echo base_url('images\user-default.png') ?>" class="img-fluid circle" style="width: 50px;" alt="">
                    <?php endif?>
                </div>
                <div class="single_rev_caption d-flex align-items-start pl-3">
                    <div class="single_capt_left">
                        <h5 class="mb-0 fs-md ft-medium lh-1 mb-2"><?php echo ($data['full_name'] ?? '') ?></h5>

                        <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                            <?php for ($i = 1; $i <= 5; $i++):?>
                                <?php if ($i <=  ($data['rating'] ?? 0)): ?>
                                    <i class="fas fa-star filled"></i>
                                <?php else: ?>
                                    <i class="fas fa-star"></i>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>

                        <span class="small">
                            <?php date('d M Y', strtotime(($data['created_at'] ?? 0))) ?>
                        </span>
                        <p>
                            <div>
                                <?php echo substr(strip_tags(($data['description'] ?? '')), 0, 300) . (strlen(strip_tags(($data['description'] ?? ''))) > 300 ? '...' : ''); ?>
                                <?php if(strlen(($data['description'] ?? '')) > 200) : ?>
                                    <a href="javascript:void(0)" class="show-more-reviews" data-description="<?php echo ($data['description'] ?? '') ?>">...Show more</a>
                                <?php endif; ?>
                            </div>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif ?>