<div id="main-wrapper">
    <?php $this->load->view('Breadcrumb',['current' => $title, 'middle' => ['my_account' => 'profile-info']]); ?>
    <section class="middle">
        <div class="container">
            <?php $this->load->view('front/SessionMessages'); ?>
            <div class="row align-items-start justify-content-between">
                <?php $this->load->view('front/myAccount/common-file'); ?>
                <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                    <div class="row align-items-center">
                    <form class="row m-0" method="post" enctype="multipart/form-data" action="<?php echo base_url('profile-info'); ?>">
                        <input type="hidden" name="id" value="<?php echo ($userDataArray['id'] ?? ''); ?>">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="text-dark ft-medium">First Name:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" value="<?php echo ($userDataArray['first_name'] ?? '') ?>" name="first_name">
                                <?php echo form_error('first_name', '<div class="text-danger">', '</div>'); ?>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="text-dark ft-medium">Last Name:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" value="<?php echo ($userDataArray['last_name'] ?? '') ?>" name="last_name">
                                <?php echo form_error('last_name', '<div class="text-danger">', '</div>'); ?>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="text-dark ft-medium">Email Address:<span style="color:red;">*</span></label>
                                <input type="email" class="form-control" value="<?php echo ($userDataArray['email'] ?? '') ?>" name="email">
                                <?php echo form_error('email', '<div class="text-danger">', '</div>'); ?>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="text-dark ft-medium">Phone Number:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" value="<?php echo ($userDataArray['phone'] ?? '') ?>" name="phone">
                                <?php echo form_error('phone', '<div class="text-danger">', '</div>'); ?>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="text-dark ft-medium">Image:</label><br>
                                <input type="file" name="image" onchange="AjaxUploadImage(this)">
                                <?php if(isset($userDataArray['image']) && !empty($userDataArray['image']) && file_exists($userDataArray['image'])): ?>
                                    <img src="<?php echo !empty($userDataArray['image']) && file_exists($userDataArray['image']) ? base_url($userDataArray['image']) : base_url('public/assets/admin/dist/img/no-image.png'); ?>" alt="User Image" style="border: 1px solid #ccc; margin-top: 5px;" width="150" id="DisplayImage">
                                <?php else: ?>
                                    <img src="<?php echo base_url('public/assets/admin/dist/img/no-image.png'); ?>" alt="User Image" style="border: 1px solid #ccc; margin-top: 5px; padding: 20px;" width="150" id="DisplayImage">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-dark">Save Changes</button>
                            </div>
                        </div>
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#profileinfo").addClass('active');
    });
</script>
