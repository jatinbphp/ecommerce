<div id="main-wrapper">
    <?php $this->load->view('Breadcrumb',['current' => $title, 'middle' => ['my_account' => 'profile-info']]); ?>
    <section class="middle addresses-page">
        <div class="container">
            <?php $this->load->view('SessionMessages'); ?>
            <div class="row justify-content-center justify-content-between">
                <?php $this->load->view('front/myAccount/common-file'); ?>
                <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                    <div class="row align-items-start">
                        <?php if (!empty($userAddresses)) : ?>
                            <?php foreach ($userAddresses as $address) : ?>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" id="address-box-<?php echo ($address['id'] ?? '')   ?>">
                                <div class="card-wrap border rounded mb-4">
                                    <div class="card-wrap-header px-3 py-2 br-bottom d-flex align-items-center justify-content-between">
                                        <div class="card-header-flex">
                                            <h4 class="fs-md ft-bold mb-1">Delivery Address</h4>
                                        </div>
                                        <div class="card-head-last-flex">
                                            <a class="border p-3 circle text-dark d-inline-flex align-items-center justify-content-center" href="<?php echo site_url('profile-update-data/'.($address['id'] ?? 0)); ?>">
                                                <i class="fas fa-pen-nib position-absolute"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="border bg-white text-danger p-3 circle text-dark d-inline-flex align-items-center justify-content-center deleteRecord" data-id="<?php echo ($address['id'] ?? 0); ?>">
                                                <i class="fas fa-times position-absolute"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-wrap-body px-3 py-3">
                                        <h5 class="ft-medium mb-1">
                                            <?php echo !empty($address['first_name']) ? $address['first_name']:""   ?>
                                        </h5>
                                        <p>
                                            <?= (isset($address['title']) && !empty($address['title']) ? '<br><b>' . $address['title'] . '</b>' : '') . 
                                                (isset($address['company']) && !empty($address['company']) ? '<br>' . $address['company'] : '') . 
                                                (isset($address['address_line1']) && !empty($address['address_line1']) ? '<br>' . $address['address_line1'] . (isset($address['address_line2']) && !empty($address['address_line2']) ? ',' : '') : '') . 
                                                (isset($address['address_line2']) && !empty($address['address_line2']) ? '<br>' . $address['address_line2'] : '') . 
                                                (isset($address['pincode']) && !empty($address['pincode']) ? '<br>' . $address['pincode'] . ' - ' : '') . 
                                                (isset($address['city']) && !empty($address['city']) ? $address['city'] . (isset($address['state']) && !empty($address['state']) ? ',' : '') : '') . 
                                                (isset($address['state']) && !empty($address['state']) ? $address['state'] . (isset($address['country']) && !empty($address['country']) ? ',' : '') : '') . 
                                                (isset($address['country']) && !empty($address['country']) ? $address['country'] : '') . '<br>' . 
                                                (isset($address['mobile_phone']) && !empty($address['mobile_phone']) ? '<span class="text-dark ft-medium">Call:</span> ' . $address['mobile_phone'] : '') 
                                            ?>
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
    $(document).ready(function() {
        $("#addresses").addClass('active');
    });
</script>