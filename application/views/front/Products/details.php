<section class="middle">
    <div class="container">
        <?php $this->load->view('front/Products/view');  ?>
    </div>
</section>
<section class="middle">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-11 col-lg-12 col-md-12 col-sm-12">
                <ul class="nav nav-tabs b-0 d-flex align-items-center justify-content-center simple_tab_links mb-4" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="description-tab" href="#description" data-toggle="tab" role="tab" aria-controls="description" aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="#information" id="information-tab" data-toggle="tab" role="tab" aria-controls="information" aria-selected="false">Additional information</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="#product-reviews" id="product-reviews-tab" data-toggle="tab" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <!-- Description Content -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                        <?php $this->load->view('front/Products/DetailsTab/Description'); ?>
                    </div>
                    <!-- Additional Content -->
                    <div class="tab-pane fade" id="information" role="tabpanel" aria-labelledby="information-tab">
                        <?php $this->load->view('front/Products/DetailsTab/AdditionalInfo'); ?>
                    </div>
                    <!-- Reviews Content -->
                    <div class="tab-pane fade" id="product-reviews" role="tabpanel" aria-labelledby="product-reviews-tab">
                        <?php $this->load->view('front/Products/DetailsTab/Reviews'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>