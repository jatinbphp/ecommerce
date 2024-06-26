<!DOCTYPE html>
<html lang="" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no"/>
    <title>Ecommerce</title>
    <link rel="shortcut icon" href="<?php echo base_url('images/favicon.ico') ?>" type="image/x-icon" />
    <link href="<?php echo base_url('css/styles.css'); ?>" rel="stylesheet">
    <script type="text/javascript">const baseUrl = "<?php echo base_url(); ?>";</script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <link rel="stylesheet" href="<?php echo base_url('public/assets/admin/plugins/select2/select2.min.css') ?>">
    <!-- <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet"> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script src="<?php echo base_url('public/assets/admin/plugins/jquery/jquery.min.js') ?>"></script>
    <script src="<?php echo base_url('public/assets/front/dist/js/cartData.js') ?>"></script>
    <meta name="<?php echo $this->security->get_csrf_token_name(); ?>" content="<?= $this->security->get_csrf_hash(); ?>">
    <script>
        function updateCsrfToken() {
            fetch(baseUrl+ 'get-tocken', {
                method: 'GET',
            }).then(function(result) {
                result.json().then(function(data) {
                    $('input[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').val(data.csrf_token_value);
                    $('meta[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').attr('content', data.csrf_token_value);
                })
            });
        }
        function getTockenName() {
            return '<?php echo $this->security->get_csrf_token_name(); ?>';
        }
        function getTockenValue() {
            return $('meta[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').attr('content');
        }
    </script>
</head>
    <body>
  <div class="loader-bg d-none" id='loader'>
    <span class="loader"></span>
    </div>
        <div id="main-wrapper">
            <div class="header header-light">
                <div class="container">
                    <nav id="navigation" class="navigation navigation-landscape">
                        <div class="nav-header">
                            <a class="nav-brand" href="<?php echo base_url(); ?>">
                                <img src="<?php echo base_url('images/logo.png')?>" class="logo" alt="" />
                            </a>
                            <div class="nav-toggle"></div>
                            <div class="mobile_nav">
                                <ul>
                                    <li>
                                        <a href="javaScript:;" onclick="openSearch()">
                                        <i class="lni lni-search-alt"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javaScript:;">
                                        <i class="lni lni-user"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javaScript:;" onclick="openWishlist()">
                                        <i class="lni lni-heart"></i><span class="dn-counter wishlist-counter">0</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javaScript:;" onclick="openCart()">
                                        <i class="lni lni-shopping-basket"></i><span class="dn-counter user-cart-counter">0</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="nav-menus-wrapper" style="transition-property: none;">
                            <ul class="nav-menu">
                                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li><a href="<?php echo base_url('shop'); ?>">Shop</a></li>
                                <?php if (isset($footer_data['headerMenuCategoriesNames']) && is_array($footer_data['headerMenuCategoriesNames']) && count($footer_data['headerMenuCategoriesNames'])): ?>
                                    <li>
                                        <a href="javascript:void(0);">Trendings</a>
                                        <ul class="nav-dropdown nav-submenu">
                                            <?php foreach ($footer_data['headerMenuCategoriesNames'] as $key => $categoryName): ?>
                                                <li><a href="<?php echo base_url("shop/categories/$key") ?>"><?php echo $categoryName; ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                                <li><a href="<?php echo base_url('about-us'); ?>">About Us</a></li>
                                <li><a href="<?php echo base_url('contact'); ?>">Contact Us</a></li>
                            </ul>
                            <ul class="nav-menu nav-menu-social align-to-right">
                                <li>
                                    <a href="javaScript:;" onclick="openSearch()">
                                    <i class="lni lni-search-alt"></i>
                                    </a>
                                </li>
                                <li class="dropdown js-dropdown">
                                    <a href="javascript:void(0)" class="popup-title" data-toggle="dropdown" title="User" aria-label="user dropdown">
                                        <i class="lni lni-user"></i>
                                    </a>
                                    <ul class="dropdown-menu popup-content link">
                                        <?php if ($this->session->userdata('logged_in')): ?>
                                            <li>
                                                <a href="<?php echo base_url('profile-info'); ?>" class="dropdown-item medium text-medium">My Account</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url('shopping-cart'); ?>" class="dropdown-item medium text-medium">Shopping Cart</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url('my-orders'); ?>" class="dropdown-item medium text-medium">My Orders</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url('my-wishlist'); ?>" class="dropdown-item medium text-medium">My Wishlist</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url('logout'); ?>" class="dropdown-item medium text-medium">Log Out</a>
                                            </li>
                                            
                                         <?php else: ?>
                                            <li>
                                                <a href="<?php echo base_url('shopping-cart'); ?>" class="dropdown-item medium text-medium">Shopping Cart</a>
                                            </li>
                                            <li>
                                                <a href=<?php echo base_url('signIn'); ?> class="dropdown-item medium text-medium">Sign In</a>
                                            </li>
                                         <?php endif; ?>
                                    </ul>
                                </li>
                                <?php if ($this->session->userdata('logged_in')): ?>
                                    <li>
                                        <a href="javaScript:;" onclick="openWishlist()">
                                        <i class="lni lni-heart"></i><span class="dn-counter wishlist-counter"><?php echo isset($wishlistProductId) ? count($wishlistProductId) :  0; ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <a href="javaScript:;" onclick="openCart()">
                                        <i class="lni lni-shopping-basket"></i><span class="dn-counter user-cart-counter"><?php echo (isset($usrCartCounter) && $usrCartCounter > 0) ? $usrCartCounter :  0; ?></span>
                                    </a>
                                    <?php if (!$this->session->userdata('logged_in')): ?>
                                        <script>
                                            var data = localStorage.getItem('cartData');
                                            if(data){
                                                $('.user-cart-counter').text(JSON.parse(data).length);    
                                            }
                                            updateCartData();
                                        </script>    
                                    <?php endif  ?>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

       
        

