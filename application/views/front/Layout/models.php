            <!-- Product View Modal -->
            <div class="modal fade lg-modal" id="quickview" tabindex="-1" role="dialog" aria-labelledby="quickviewmodal" aria-hidden="true">
                <div class="modal-dialog modal-xl login-pop-form" role="document">
                    <div class="modal-content" id="quickviewmodal">
                        <div class="modal-headers">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="ti-close"></span>
                            </button>
                        </div>
                        <div class="modal-body" id="quickviewbody">
                            <!-- dynamic loading quick view content with ajax -->
                        </div>
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
                    <div class="right-ch-sideBar">
                        <div class="cart_select_items py-2">
                            <div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
                                <div class="cart_single d-flex align-items-center">
                                    <div class="cart_selected_single_thumb">
                                        <a href="javaScript:;"><img src="<?php echo base_url('images/4.jpg')?>" width="60" class="img-fluid" alt="" /></a>
                                    </div>
                                    <div class="cart_single_caption pl-2">
                                        <h4 class="product_title fs-sm ft-medium mb-0 lh-1">Women Striped Shirt Dress</h4>
                                        <p class="mb-2"><span class="text-dark ft-medium small">36</span>, <span class="text-dark small">Red</span></p>
                                        <h4 class="fs-md ft-medium mb-0 lh-1">$129</h4>
                                    </div>
                                </div>
                                <div class="fls_last"><button class="close_slide gray"><i class="ti-close"></i></button></div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
                                <div class="cart_single d-flex align-items-center">
                                    <div class="cart_selected_single_thumb">
                                        <a href="javaScript:;"><img src="<?php echo base_url('images/7.jpg')?>" width="60" class="img-fluid" alt="" /></a>
                                    </div>
                                    <div class="cart_single_caption pl-2">
                                        <h4 class="product_title fs-sm ft-medium mb-0 lh-1">Girls Floral Print Jumpsuit</h4>
                                        <p class="mb-2"><span class="text-dark ft-medium small">36</span>, <span class="text-dark small">Red</span></p>
                                        <h4 class="fs-md ft-medium mb-0 lh-1">$129</h4>
                                    </div>
                                </div>
                                <div class="fls_last"><button class="close_slide gray"><i class="ti-close"></i></button></div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between px-3 py-3">
                                <div class="cart_single d-flex align-items-center">
                                    <div class="cart_selected_single_thumb">
                                        <a href="javaScript:;"><img src="<?php echo base_url('images/8.jpg')?>" width="60" class="img-fluid" alt="" /></a>
                                    </div>
                                    <div class="cart_single_caption pl-2">
                                        <h4 class="product_title fs-sm ft-medium mb-0 lh-1">Girls Solid A-Line Dress</h4>
                                        <p class="mb-2"><span class="text-dark ft-medium small">30</span>, <span class="text-dark small">Blue</span></p>
                                        <h4 class="fs-md ft-medium mb-0 lh-1">$100</h4>
                                    </div>
                                </div>
                                <div class="fls_last"><button class="close_slide gray"><i class="ti-close"></i></button></div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between br-top br-bottom px-3 py-3">
                            <h6 class="mb-0">Subtotal</h6>
                            <h3 class="mb-0 ft-medium">$417</h3>
                        </div>
                        <div class="cart_action px-3 py-3">
                            <div class="form-group">
                                <button type="button" class="btn d-block full-width btn-dark">Move To Cart</button>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn d-block full-width btn-dark-light">Edit or View</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart -->
            <div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="Cart">
                <div class="rightMenu-scroll">
                    <div class="d-flex align-items-center justify-content-between slide-head py-3 px-3">
                        <h4 class="cart_heading fs-md ft-medium mb-0">Products List</h4>
                        <button onclick="closeCart()" class="close_slide"><i class="ti-close"></i></button>
                    </div>
                    <div class="right-ch-sideBar">
                        <div class="cart_select_items py-2">
                            <div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
                                <div class="cart_single d-flex align-items-center">
                                    <div class="cart_selected_single_thumb">
                                        <a href="javaScript:;"><img src="<?php echo base_url('images/4.jpg')?>" width="60" class="img-fluid" alt="" /></a>
                                    </div>
                                    <div class="cart_single_caption pl-2">
                                        <h4 class="product_title fs-sm ft-medium mb-0 lh-1">Women Striped Shirt Dress</h4>
                                        <p class="mb-2"><span class="text-dark ft-medium small">36</span>, <span class="text-dark small">Red</span></p>
                                        <h4 class="fs-md ft-medium mb-0 lh-1">$129</h4>
                                    </div>
                                </div>
                                <div class="fls_last"><button class="close_slide gray"><i class="ti-close"></i></button></div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
                                <div class="cart_single d-flex align-items-center">
                                    <div class="cart_selected_single_thumb">
                                        <a href="javaScript:;"><img src="<?php echo base_url('images/7.jpg')?>" width="60" class="img-fluid" alt="" /></a>
                                    </div>
                                    <div class="cart_single_caption pl-2">
                                        <h4 class="product_title fs-sm ft-medium mb-0 lh-1">Girls Floral Print Jumpsuit</h4>
                                        <p class="mb-2"><span class="text-dark ft-medium small">36</span>, <span class="text-dark small">Red</span></p>
                                        <h4 class="fs-md ft-medium mb-0 lh-1">$129</h4>
                                    </div>
                                </div>
                                <div class="fls_last"><button class="close_slide gray"><i class="ti-close"></i></button></div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between px-3 py-3">
                                <div class="cart_single d-flex align-items-center">
                                    <div class="cart_selected_single_thumb">
                                        <a href="javaScript:;"><img src="<?php echo base_url('images/8.jpg')?>" width="60" class="img-fluid" alt="" /></a>
                                    </div>
                                    <div class="cart_single_caption pl-2">
                                        <h4 class="product_title fs-sm ft-medium mb-0 lh-1">Girls Solid A-Line Dress</h4>
                                        <p class="mb-2"><span class="text-dark ft-medium small">30</span>, <span class="text-dark small">Blue</span></p>
                                        <h4 class="fs-md ft-medium mb-0 lh-1">$100</h4>
                                    </div>
                                </div>
                                <div class="fls_last"><button class="close_slide gray"><i class="ti-close"></i></button></div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between br-top br-bottom px-3 py-3">
                            <h6 class="mb-0">Subtotal</h6>
                            <h3 class="mb-0 ft-medium">$1023</h3>
                        </div>
                        <div class="cart_action px-3 py-3">
                            <div class="form-group">
                                <button type="button" class="btn d-block full-width btn-dark">Checkout Now</button>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn d-block full-width btn-dark-light">Edit or View</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>
        </div>

        <script src="<?php echo base_url('js/jquery.min.js'); ?>"></script>
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

        <script>
            function openWishlist() {
            	document.getElementById("Wishlist").style.display = "block";
            }
            function closeWishlist() {
            	document.getElementById("Wishlist").style.display = "none";
            }
        </script>
        <script>
            function openCart() {
            	document.getElementById("Cart").style.display = "block";
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