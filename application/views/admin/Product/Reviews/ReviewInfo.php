<div class="col-md-12">
    <div class="col-md-1" style="float: left;">
    <?php if(isset($userImage) && file_exists($userImage) && isset($data['user_id']) && $this->session->userdata('userId') == $data['user_id']): ?>
        <img src="<?php echo base_url($userImage) ?>" class="img-fluid circle" style="width: 50px;" alt="" />
    <?php else: ?>
        <img src="<?php echo base_url('uploads\users\user-default.png') ?>" class="img-fluid circle" style="width: 50px;" alt="">
    <?php endif?>
    </div>
    <div class="col-md-11 pull-left"  style="float: left;">
        <h5><?php echo $full_name; ?></h5>

        <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <?php if ($i <= $rating): ?>
                    <i class="fas fa-star filled"></i>
                <?php else: ?>
                    <i class="far fa-star"></i>
                <?php endif ?>
            <?php endfor ?>
        </div>

        <span class="small">
            <?php date('d M Y', strtotime(($created_at ?? 0))) ?>
        </span>
        <p>
            <div>
                <?php echo substr(strip_tags(($description ?? '')), 0, 300) . (strlen(strip_tags(($description ?? ''))) > 300 ? '...' : ''); ?>
                <?php if(strlen(($description ?? '')) > 200) : ?>
                    <a href="javascript:void(0)" class="show-more-reviews" data-description="<?php echo ($description ?? '') ?>">...Show more</a>
                <?php endif; ?>
            </div>
        </p>
    </div>
</div>