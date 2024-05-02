<div id="main-wrapper">
    <?php $this->load->view('Breadcrumb',['current' => $title, 'middle' => ['my_account' => 'profile-info']]); ?>
    <section class="middle">
        <div class="container">
            <?php $this->load->view('front/SessionMessages'); ?>
            <div class="row align-items-start justify-content-between">
                <?php $this->load->view('front/myAccount/common-file'); ?>
                <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                    <form action="<?php echo base_url('profile-add-address'); ?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12 col-lg-12 col-xl-12 col-md-12 mb-3">
                                <h4 class="ft-medium fs-lg">Add Address</h4>
                            </div>
                        </div>
                        <?php $this->load->view('front/myAccount/address/form'); ?>
                        <button type="submit" class="btn btn-dark full-width">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#addresses").addClass('active');
    });
</script>
