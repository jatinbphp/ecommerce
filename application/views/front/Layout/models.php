            <!-- Product View Modal -->
            <div class="modal fade lg-modal" id="quickview" tabindex="-1" role="dialog" aria-labelledby="quickviewmodal" aria-hidden="true">
                <div class="modal-dialog modal-xl login-pop-form" role="document">
                    <div class="modal-content" id="quickviewmodal">
                        <div class="modal-headers">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="ti-close"></span>
                            </button>
                        </div>
                        <div class="modal-body" id="quickviewbody"></div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Search -->
            <div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="Search">
                <div class="rightMenu-scroll">
                    <div class="d-flex align-items-center justify-content-between slide-head py-3 px-3">
                        <h4 class="cart_heading fs-md ft-medium mb-0">Search Products</h4>
                        <button onclick="closeSearch()" class="close_slide"><i class="ti-close"></i></button>
                    </div>
                    <div class="cart_action px-3 py-4">
                        <form class="form m-0 p-0">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Product Keyword.." />
                            </div>
                            <div class="form-group">
                                <select class="custom-select">
                                    <option value="1" selected="">Choose Category</option>
                                    <option value="2">Men's Store</option>
                                    <option value="3">Women's Store</option>
                                    <option value="4">Kid's Fashion</option>
                                    <option value="5">Accessories</option>
                                </select>
                            </div>
                            <div class="form-group mb-0">
                                <button type="button" class="btn d-block full-width btn-dark">Search Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Wishlist -->
            <div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="Wishlist">
                <div class="rightMenu-scroll">
                    <div class="d-flex align-items-center justify-content-between slide-head py-3 px-3">
                        <h4 class="cart_heading fs-md ft-medium mb-0">Saved Products</h4>
                        <button onclick="closeWishlist()" class="close_slide"><i class="ti-close"></i></button>
                    </div>
                    <div id="userWishlist"></div>
                </div>
            </div>

            <!-- Cart Start -->
            <div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="Cart">
                <div class="rightMenu-scroll">
                    <div class="d-flex align-items-center justify-content-between slide-head py-3 px-3">
                        <h4 class="cart_heading fs-md ft-medium mb-0">Cart</h4>
                        <button onclick="closeCart()" class="close_slide"><i class="ti-close"></i></button>
                    </div>
                    <div id="usrCartDataMenu"></div>
                </div>
            </div>
            <!-- Cart End -->
            
            <a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>
        </div>

        <script src="<?php echo base_url('js/popper.min.js'); ?>"></script>
        <script src="<?php echo base_url('js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('js/ion.rangeSlider.min.js'); ?>"></script>
        <script src="<?php echo base_url('js/slick.js'); ?>"></script>
        <script src="<?php echo base_url('js/slider-bg.js'); ?>"></script>
        <script src="<?php echo base_url('js/lightbox.js'); ?>"></script> 
        <script src="<?php echo base_url('js/smoothproducts.js'); ?>"></script>
        <script src="<?php echo base_url('js/snackbar.min.js'); ?>"></script>
        <script src="<?php echo base_url('js/jQuery.style.switcher.js'); ?>"></script>
        <script src="<?php echo base_url('js/custom.js'); ?>"></script>
        <script src="<?php echo base_url('js/jquery.validate.min.js'); ?>"></script>
        <script src="<?php echo base_url('public/assets/front/dist/js/frontValidations.js'); ?>"></script>
        <script src="<?php echo base_url('public/assets/front/dist/js/common.js'); ?>"></script>
        <script src="<?php echo base_url('public/assets/front/dist/js/home.js'); ?>"></script>
        <script src="<?php echo base_url('public/assets/front/dist/js/shop.js'); ?>"></script>
        <script src="<?php echo base_url('public/assets/admin/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
        <script src="<?php echo base_url('public/assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
        <script src="<?php echo base_url('public/assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
        <script src="<?php echo base_url('public/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
        <script src="<?php echo base_url('public/assets/admin/plugins/select2/select2.full.min.js') ?>"></script>

        <!-- all the script for home page -->
        <script src="<?php echo base_url('public/assets/front/dist/js/homePage.js'); ?>"></script>

        <script>
            function openWishlist() {
                //userWishlist
            	document.getElementById("Wishlist").style.display = "block";
                $.ajax({
                    url: "wishlist-data", 
                    method: 'GET',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                    success: function(response) {
                        $("#userWishlist").html(response.wishlistHtml);
                        $(".user-cart-counter").html(response.cartCounter);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error:', textStatus, errorThrown);
                    }
                });
            }
            function closeWishlist() {
            	document.getElementById("Wishlist").style.display = "none";
            }
        </script>
        <script>
            function openCart() {
            	document.getElementById("Cart").style.display = "block";

                $.ajax({
                    url: "cart/get-user-cart", 
                    method: 'GET',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                    success: function(response) {
                        $("#usrCartDataMenu").html(response.cartView);
                        $(".user-cart-counter").html(response.cartCounter);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error:', textStatus, errorThrown);
                    }
                });


            }
            function closeCart() {
            	document.getElementById("Cart").style.display = "none";
            }
        </script>
        <script>
            function openSearch() {
            	document.getElementById("Search").style.display = "block";
            }
            function closeSearch() {
            	document.getElementById("Search").style.display = "none";
            }
        </script>	
    </body>
</html>