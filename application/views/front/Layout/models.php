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

            <!-- Review Desc Modal -->
            <div class="modal fade" id="reviewDesc" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Review Description</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body card card-info card-outline">
                            <div id="reviewDescbody"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                        <form id="searchProductForm" class="form m-0 p-0">
                            <div class="form-group">
                                <input type="text" id="keyword" class="form-control" placeholder="Product Keyword..">
                            </div>
                            <div class="form-group mb-0">
                                <button type="button" onclick="searchProducts()" class="btn d-block full-width btn-dark">Search Product</button>
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

            <div class="modal fade" id="cancelOrder" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Review Description</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body card card-info card-outline">
                            <label for="reason" class="small text-dark ft-medium">Reason</label>
                            <textarea name="reason" id="reason" class="form-control ht-80" placeholder="Type Your Reason"></textarea>
                            <input type='hidden' id='orderId'>
                        </div>
                        <div class="modal-footer">
                            <button type="button" onClick="cancelOrderStatus()" class="btn btn-dark">Cancel Order</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subscription Model -->
            <div class="modal fade" id="subscription" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Subscription Management</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body card card-info card-outline">
                            <div id="subscriptionbody"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            
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

        <script>
            function openWishlist() {
                //userWishlist
            	document.getElementById("Wishlist").style.display = "block";
                $.ajax({
                    url: baseUrl+"wishlist-data", 
                    type: 'GET',
                    success: function(response) {
                        $("#userWishlist").html(response.wishlistHtml);
                        $(".user-cart-counter").html(response.cartCounter);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error:', textStatus, errorThrown);
                    }
                }).always(function (dataOrjqXHR, textStatus, jqXHRorErrorThrown) {
                    updateCsrfToken();
                });
            }

            function closeWishlist() {
            	document.getElementById("Wishlist").style.display = "none";
            }

            function openCart() {
            	document.getElementById("Cart").style.display = "block";
                var cartDataFromLocalStorage = localStorage.getItem('cartData');
                var tockenName = getTockenName();
                var tockenValue = getTockenValue();
                var dataObj = {cartData: cartDataFromLocalStorage};
                dataObj[tockenName] = tockenValue;
                $.ajax({
                    url: baseUrl+"cart/get-user-cart", 
                    type: 'POST',
                    data: dataObj,
                    success: function(response) {
                        $("#usrCartDataMenu").html(response.cartView);
                        $(".user-cart-counter").html(response.cartCounter);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error:', textStatus, errorThrown);
                    }
                }).always(function (dataOrjqXHR, textStatus, jqXHRorErrorThrown) {
                    updateCsrfToken();
                });
            }

            function closeCart() {
            	document.getElementById("Cart").style.display = "none";
            }

            function openSearch() {
            	document.getElementById("Search").style.display = "block";
            }
            function closeSearch() {
            	document.getElementById("Search").style.display = "none";
            }

            function searchProducts() {
                var keyword = $('#keyword').val();

                if(!keyword){
                    SnackbarAlert('Please add product keyword.');
                    return;
                }

                $.ajax({
                    url: baseUrl+'products',
                    type: 'GET',
                    data: {
                        keyword: keyword,
                        viewType: 'filter'
                    },
                    success: function(response) {
                        if (response.html) {
                            closeSearch();
                            $('#search-text').text('Results for "' + keyword + '"').removeClass('d-none');
                            $('.rows-products').html('').html(response.html);
                            $('#filterCount').html($(".product_grid").length);
                            $('#loader').addClass('d-none');
                            if ($('.ti-view-list').parent('a').hasClass('active')) {
                                $('.filters').removeClass().addClass('col-12 filters');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                }).always(function (dataOrjqXHR, textStatus, jqXHRorErrorThrown) {
                    updateCsrfToken();
                });
            }

            $('.filter_wraps .single_fitres a').on('click',function(e) {
                if($(this).hasClass('list')) {
                    $('.filter_wraps .single_fitres a.list').addClass('active');
                    $('.filter_wraps .single_fitres a.grid').removeClass('active');
                    $('.rows-products').removeClass('grid').addClass('list');
                    $('.rows-products .col-6').removeClass('col-xl-4 col-lg-4 col-md-6 col-6').addClass('col-12');
                    $('.product_grid .card-footer .text-left .d-none').removeClass('d-none').addClass('d-block');
                }
                else if ($(this).hasClass('grid')) {
                    $('.filter_wraps .single_fitres a.grid').addClass('active');
                    $('.filter_wraps .single_fitres a.list').removeClass('active');
                    $('.rows-products').removeClass('list').addClass('grid');
                    $('.rows-products .col-12').removeClass('col-12').addClass('col-xl-4 col-lg-4 col-md-6 col-6');
                    $('.product_grid .card-footer .text-left .d-block').removeClass('d-block').addClass('d-none');
                }
            });

            function cancelOrderStatus(){
                var id = $('#orderId').val();
                var reason = $('#reason').val();
                if(!id || id==0){
                    return;
                }
                var tockenName = getTockenName();
                var tockenValue = getTockenValue();
                var dataObj = { id: id, reason: reason};
                dataObj[tockenName] = tockenValue;
                $('#loader').removeClass('d-none');
                $.ajax({
                url: baseUrl+'cancel-order',
                    type: 'post',
                    data: dataObj,
                    success: function(data) {
                        $('#loader').addClass('d-none');
                        if(data.status == 1){
                            location.reload();
                        } else {
                            $('#cancelOrder').modal('hide');
                            swal("Error", "Something is wrong!", "error");
                        }                         
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                }).always(function (dataOrjqXHR, textStatus, jqXHRorErrorThrown) {
                    updateCsrfToken();
                });
            }
        </script>
        <!--Start of Tawk.to Script-->
        <script type="text/javascript">
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
                var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                s1.async=true;
                s1.src='https://embed.tawk.to/5a8577bdd7591465c707b18c/default';
                s1.charset='UTF-8';
                s1.setAttribute('crossorigin','*');
                s0.parentNode.insertBefore(s1,s0);
            })();
        </script>
        <!--End of Tawk.to Script-->
    </body>
</html>