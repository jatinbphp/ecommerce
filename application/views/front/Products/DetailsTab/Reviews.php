<div id='reviews_info'>
    <?php $this->load->view('front/Products/DetailsTab/ReviewsInfo'); ?>
</div>
<div class="reviews_rate">
    <?php echo form_open_multipart(base_url('reviews/add-review'), ['id' => 'reviewForm', 'class' => 'form-horizontal row']); ?>
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
                <?php echo form_button(['type' => 'submit', 'content' => 'Submit Review <i class="lni lni-arrow-right"></i>', 'class' => 'btn btn-dark stretched-link hover-black']); ?>
            </div>
        </div>
    <?php echo form_close(); ?>
</div>