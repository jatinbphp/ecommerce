<div id="main-wrapper">
    <?php $this->load->view('Breadcrumb',['current' => $title, 'middle' => ['my_account' => 'profile-info']]); ?>
    <section class="middle">
        <div class="container">
            <?php $this->load->view('front/SessionMessages'); ?>
            <div class="row align-items-start justify-content-between">
                <?php $this->load->view('front/myAccount/common-file'); ?>
                <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                    <form action="<?php echo site_url('profile-update-data/' . ($userAddresses['id'] ?? 0)); ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <div class="row">
                            <div class="col-12 col-lg-12 col-xl-12 col-md-12 mb-3">
                                <h4 class="ft-medium fs-lg">Edit Address</h4>
                            </div>
                        </div>
                        <?php $this->load->view('front/myAccount/address/form'); ?>
                        <button type="submit" class="btn btn-dark full-width">Update</button>
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
