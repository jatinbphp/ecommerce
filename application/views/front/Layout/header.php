<!DOCTYPE html>
<html lang="" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="format-detection" content="telephone=no"/>
        <title>Blu leisure</title>
        <link href="<?php echo base_url('css/styles.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('css/bootstrap.min.css'); ?>" rel="stylesheet">
    </head>
    <body>
        <div id="main-wrapper">
            <div class="header header-light">
                <div class="container">
                    <nav id="navigation" class="navigation navigation-landscape">
                        <div class="nav-header">
                            <a class="nav-brand" href="javaScript:;">
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
                                <li><a href="index.html">Home</a></li>
                                <li><a href="about-us.html">About Us</a></li>
                                <li>
                                    <a href="shop.html">Shop</a>
                                <li>
                                    <a href="javascript:void(0);">Clothing</a>
                                    <ul class="nav-dropdown nav-submenu">
                                        <li><a href="#">Female</a></li>
                                        <li><a href="#">Male</a></li>
                                        <li><a href="#">Kids</a></li>
                                    </ul>
                                </li>
                                <li><a href="shop.html">Accessories</a></li>
                                <li><a href="contact.html">Contact</a></li>
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
                                        <li class="current">
                                            <a href="javascript:void(0);" class="dropdown-item medium text-medium">Cart</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item medium text-medium">Checout</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item medium text-medium">Wishlist</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item medium text-medium">Log Out</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javaScript:;" onclick="openWishlist()">
                                    <i class="lni lni-heart"></i><span class="dn-counter">2</span>
                                    </a>
                                </li>
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