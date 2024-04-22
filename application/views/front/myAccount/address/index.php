<div id="main-wrapper">
    <div class="gray py-3">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url(''); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url('profile-info'); ?>">My Account</a></li>
                            <li class="breadcrumb-item"><a href="#"><?php echo $title; ?></a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
   

    <section class="middle addresses-page">
     <div class="container">
            <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                    <?php elseif($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
            <?php endif; ?>
        <div class="row justify-content-center justify-content-between">

             <?php $this->load->view('front/myAccount/common-file'); ?>
             

            <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                <div class="row align-items-start">

                <?php if (!empty($userAddresses)) : ?>
                        <?php foreach ($userAddresses as $address) : ?>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" id="address-box-{{ $address->id ?? null }}">
                            <div class="card-wrap border rounded mb-4">
                                <div class="card-wrap-header px-3 py-2 br-bottom d-flex align-items-center justify-content-between">
                                    <div class="card-header-flex">
                                        <h4 class="fs-md ft-bold mb-1">Delivery Address</h4>
                                    </div>
                                    <div class="card-head-last-flex">
                                        <a class="border p-3 circle text-dark d-inline-flex align-items-center justify-content-center" href="<?php echo site_url('profile-update-data/'.$address['id']); ?>">
                                            <i class="fas fa-pen-nib position-absolute"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="border bg-white text-danger p-3 circle text-dark d-inline-flex align-items-center justify-content-center deleteRecord" data-id="<?php echo $address['id']; ?>">
                                            <i class="fas fa-times position-absolute"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-wrap-body px-3 py-3">
                                    <h5 class="ft-medium mb-1">
                                        <?php echo !empty($address['first_name'])? $address['first_name']:""   ?>
                                    </h5>
                                    <p>
                                        <?php if (!empty($address['title'])) : ?>
                                        <br><b><?php echo $address['title']; ?></b>
                                        <?php endif; ?>
                                        <?php if (!empty($address['company'])) : ?>
                                        <br><?php echo $address['company']; ?>
                                        <?php endif; ?>
                                        <?php if (!empty($address['address_line1'])) : ?>
                                        <br><?php echo $address['address_line1']; ?><?php if (!empty($address['address_line2'])) : ?>,<?php endif; ?>
                                        <?php endif; ?>
                                        <?php if (!empty($address['address_line2'])) : ?>
                                        <br><?php echo $address['address_line2']; ?>
                                        <?php endif; ?><br>
                                        <?php if (!empty($address['pincode'])) : ?>
                                        <?php echo $address['pincode']; ?> -
                                        <?php endif; ?>
                                        <?php if (!empty($address['city'])) : ?>
                                        <?php echo $address['city']; ?><?php if (!empty($address['state'])) : ?>,<?php endif; ?>
                                        <?php endif; ?>
                                        <?php if (!empty($address['state'])) : ?>
                                        <?php echo $address['state']; ?><?php if (!empty($address['country'])) : ?>,<?php endif; ?>
                                        <?php endif; ?>
                                        <?php if (!empty($address['country'])) : ?>
                                        <?php echo $address['country']; ?>
                                        <?php endif; ?><br>
                                        <?php if (!empty($address['mobile_phone'])) : ?>
                                        <span class="text-dark ft-medium">Call:</span> <?php echo $address['mobile_phone']; ?>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                </div>
                <div class="row align-items-start">
                       <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <a href="<?= site_url('profile-add-address') ?>" class="btn stretched-link borders full-width">
                                        <i class="fas fa-plus mr-2"></i>Add New Address
                                    </a>
                                </div>
                            </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

<script type="text/javascript">
   
</script>
