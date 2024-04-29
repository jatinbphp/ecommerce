
<?php if(isset($reviews) && count($reviews)): ?>
    <div class="reviews_info">
        <?php foreach($reviews as $data): ?>
            <div class="single_rev d-flex align-items-start py-3">
                <div class="single_rev_thumb" style="width: 50px;min-width: 50px;">
                    <?php if(isset($userImage) && file_exists($userImage) && isset($data['user_id']) && $this->session->userdata('userId') == $data['user_id']): ?>
                        <img src="<?php echo base_url($userImage) ?>" class="img-fluid circle" style="width: 50px;" alt="" />
                    <?php else: ?>
                        <img src="<?php echo base_url('uploads\users\user-default.png') ?>" class="img-fluid circle" style="width: 50px;" alt="">
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
<div class="reviews_rate">
    <?php echo form_open_multipart('add-product-review', ['id' => 'reviewForm', 'class' => 'form-horizontal row']); ?>
        <?php echo form_hidden('product_id', ($product['id'] ?? 0)); ?>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <h4>Submit Rating</h4>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="revie_stars d-flex align-items-center justify-content-between px-2 py-2 gray rounded mb-2 mt-1">
                <div class="srt_013">
                    <div class="submit-rating">
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <input id="star-<?php echo $i; ?>" type="radio" name="rating" value="<?php echo $i; ?>" <?php echo ($i == 3 ? 'checked' : ''); ?>>
                            <label for="star-<?php echo $i; ?>" title="<?php echo $i; ?> stars">
                                <i class="active fa fa-star" aria-hidden="true"></i>
                            </label>
                        <?php endfor; ?>
                    </div>                                        
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <div class="form-group">
                <label class="medium text-dark ft-medium">Full Name</label>
                <?php echo form_input(['name' => 'full_name', 'value' => (($this->session->userdata('first_name') && $this->session->userdata('last_name')) ? $this->session->userdata('first_name') .' '. $this->session->userdata('last_name') : ''), 'class' => 'form-control', 'placeholder' => 'Enter Full Name', 'id' => 'full_name']); ?>
                <div class="text-danger full_name-text"></div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <div class="form-group">
                <label class="medium text-dark ft-medium">Email Address</label>
                <?php echo form_input(['name' => 'email_address', 'value' => (($this->session->userdata('email')) ? $this->session->userdata('email') : ''), 'class' => 'form-control', 'placeholder' => 'Enter Email Address', 'id' => 'email_address']); ?>
                <div class="text-danger email_address-text"></div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                <label class="medium text-dark ft-medium">Description</label>    
                <?php echo form_textarea(['name' => 'description', 'value' => null, 'class' => 'form-control', 'placeholder' => 'Enter Description', 'id' => 'description', 'data-required' => 'true']); ?>
                <div class="text-danger description-text"></div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="form-group m-0">
                <?php echo form_button(['type' => 'submit', 'content' => 'Submit Review <i class="lni lni-arrow-right"></i>', 'class' => 'btn btn-dark stretched-link hover-black', 'name' => 'submit']); ?>
            </div>
        </div>
    <?php echo form_close(); ?>
</div>