<?php $this->load->view('Breadcrumb',['current' => $title]); ?>
<section class="middle">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-6 text-center">
                <div class="p-4 d-inline-flex align-items-center justify-content-center circle bg-light-success text-success mx-auto mb-4"><i class="lni lni-heart-filled fs-lg"></i></div>
                <h2 class="mb-2 ft-bold">Your Order is Completed!</h2>
                <?php if($this->session->userdata('logged_in')) : ?>
                    <p class="ft-regular fs-md mb-5">Your order <span class="text-body text-dark">#<?php echo $order_id?></span> has been completed. Your order details are shown for your personal accont.</p>
                    <a class="btn btn-dark" href="<?php echo base_url('my-orders'); ?>">Track Your Orders</a>
                <?php else : ?>
                    <p class="ft-regular fs-md mb-5">Your order <span class="text-body text-dark">#<?php echo $order_id?></span> has been completed.</p>
                    <a class="btn btn-dark" href="<?php echo base_url(); ?>">Continue Shopping</a>
                <?php endif ?>
            </div>
        </div>
    </div>
</section>
<script>
    var cartData = localStorage.getItem('cartData');
    if(cartData){
        $('#userCart').val(cartData);
        localStorage.removeItem('cartData');
        $('.user-cart-counter').text(0);
    }
</script>