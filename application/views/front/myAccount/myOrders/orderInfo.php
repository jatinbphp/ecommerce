<div class="container">
    <div class="row align-items-center justify-content-start m-0 py-2">
        <div class="col-xl-4 col-lg-4 col-md-4 col-12">
            <div class="cart_single align-items-start">
                <div class="cart_single_caption">
                    <p class="mb-0">
                        <?php 
                            echo "#" . $id; 
                        ?>
                    </p>
                    <h4 class="product_title fs-sm ft-medium mb-1 lh-1">
                        <?php echo isset($user['first_name']) ? $user['first_name'] : ''; ?>
                    </h4>
                    <p class="mb-2"><span class="text-dark medium">No. of Products: <?php echo $orderItems; ?></span></p>   
                    <h4 class="fs-sm ft-bold mb-0 lh-1">
                        <span class="text-muted">Total:</span> <?php echo '$' . number_format($total_amount, 2); ?>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-md-3 col-6">
            <p class="mb-1 p-0"><span class="text-muted">Status:</span></p>
            <div class="delv_status">
                <span class="ft-medium small text-primary bg-light-primary rounded px-3 py-1"><?php echo $status; ?></span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-4 col-6">
            <p class="mb-1 p-0"><span class="text-muted">Order date by:</span></p>
            <h6 class="mb-0 ft-medium fs-sm">
                <?php echo date('d, F Y', strtotime(($created_at ?? 0))); ?>
            </h6>
        </div>
        <div class="col-xl-1 col-lg-1 col-md-1 col-6">
            <a href="<?php echo base_url('order-details/'.$id); ?>" class="btn btn-sm btn-primary rounded" title="Order Details"><i class="lni lni-eye"></i></a>
        </div>
    </div>
</div>

