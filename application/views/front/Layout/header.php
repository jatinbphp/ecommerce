<!DOCTYPE html>
<html lang="" dir="ltr">
<head>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no"/>
    <title>Ecommerce</title>
    <link rel="shortcut icon" href="<?php echo base_url('images/favicon.png') ?>" type="image/x-icon" />
    <link href="<?php echo base_url('css/styles.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <link rel="stylesheet" href="<?php echo base_url('public/assets/admin/plugins/select2/select2.min.css') ?>">
    <!-- <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet"> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    
</head>
    <body>
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
                                        <i class="lni lni-heart"></i><span class="dn-counter">2</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javaScript:;" onclick="openCart()">
                                        <i class="lni lni-shopping-basket"></i><span class="dn-counter">0</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="nav-menus-wrapper" style="transition-property: none;">
                            <ul class="nav-menu">
                                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li><a href="<?php echo base_url('about-us'); ?>">About Us</a></li>
                                <li>
                                    <a href="javascript:void(0);">Shop</a>
                                    <ul class="nav-dropdown nav-submenu">
                                        <?php if (isset($footer_data['headerMenuCategoriesNames']) && is_array($footer_data['headerMenuCategoriesNames'])): ?>
                                            <?php foreach ($footer_data['headerMenuCategoriesNames'] as $categoryName): ?>
                                                <li><a href="javaScript:;"><?php echo $categoryName; ?></a></li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">Clothing</a>
                                    <ul class="nav-dropdown nav-submenu">
                                        <li><a href="#">Female</a></li>
                                        <li><a href="#">Male</a></li>
                                        <li><a href="#">Kids</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?php echo base_url('shop'); ?>">Accessories</a></li>
                                <li><a href="contact">Contact Us</a></li>
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
                                                <a href="javascript:void(0);" class="dropdown-item medium text-medium">My Orders</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item medium text-medium">My Wishlist</a>
                                            </li>
                                            <li>
                                                <a href="logout" class="dropdown-item medium text-medium">Log Out</a>
                                            </li>
                                            
                                         <?php else: ?>
                                            <li><a href="signIn" class="dropdown-item medium text-medium">Sign In</a></li>
                                         <?php endif; ?>
                                    </ul>
                                </li>
                                <?php if ($this->session->userdata('logged_in')): ?>
                                    <li>
                                        <a href="javaScript:;" onclick="openWishlist()">
                                        <i class="lni lni-heart"></i><span class="dn-counter">2</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <a href="javaScript:;" onclick="openCart()">
                                    <i class="lni lni-shopping-basket"></i><span class="dn-counter">3</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

       
        

