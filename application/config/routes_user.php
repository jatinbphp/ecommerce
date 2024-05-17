<?php
$route['default_controller'] = 'HomeController';
$route['signup'] = 'front/auth/AuthController';
$route['signIn'] = 'front/auth/AuthController/logIn';
$route['authUser'] = 'front/auth/AuthController/authUser';
$route['registerUser'] = 'front/auth/AuthController/storeUser';
$route['otpCheck'] = 'front/auth/AuthController/optCheckView';
$route['verifyOtp'] = 'front/auth/AuthController/verifyOTP';
$route['logout'] = 'front/auth/AuthController/logout';
$route['check-email'] = 'front/auth/AuthController/check_email_exists';
$route['about-us'] = 'HomeController/aboutUs';
$route['contact'] = 'front/ContactusController';
$route['contact/send_message'] = 'front/ContactusController/sendMessage';
$route['terms-conditions'] = 'HomeController/termaConditions';
$route['privecy-policy'] = 'HomeController/privecyPolicy';
$route['forgotPassword'] = 'front/auth/AuthController/forgotPassword';
$route['sendforgotPasswordLink'] = 'front/auth/AuthController/sendForgotPasswordMail';
$route['setNewPassword/(:any)'] = 'front/auth/AuthController/setNewPassword/$1';
$route['updateNewPassword'] = 'front/auth/AuthController/updateNewPassword';

$route['products'] = 'front/ProductController/index';
$route['products/show/(:num)'] = 'front/ProductController/show/$1';
$route['products/(:any)/details'] = 'front/ProductController/details/$1';
$route['products/options'] = 'front/ProductController/options';

$route['payment/process-payment'] = 'front/PaymentController/processPayment';
$route['payment/calculate-tax'] = 'front/PaymentController/calculateTax';
$route['payment/calculate-tax-with-address'] = 'front/PaymentController/calculateTaxUsingAddressId';
$route['profile-info'] = 'front/MyProfileController/edit';
$route['profile-address'] = 'HomeController/profile_address';
$route['profile-add-address'] = 'front/MyProfileController/add_address';
$route['addresses/delete/(:num)'] = 'front/MyProfileController/delete/$1';
$route['profile-address'] = 'front/MyProfileController/edit_address';
$route['profile-update-address'] = 'front/MyProfileController/edit_address';
$route['profile-update-data/(:any)'] = 'front/MyProfileController/edit_address_data/$1';
$route['change-password'] = 'front/MyProfileController/edit_password';
$route['fetch_orders'] = 'front/OrderController/fetchOrders';
$route['my-orders'] = 'front/OrderController/index';
$route['order-details/(:any)'] = 'front/OrderController/orderDetails/$1';
$route['my-wishlist'] = 'front/WishlistController/index';
$route['my-wishlist-remove/(:num)'] = 'front/WishlistController/removeItems/$1';
$route['wishlist-data'] = 'front/WishlistController/getUserWishlistData';
$route['wishlist/add_to_faviourits'] = 'front/WishlistController/addToFaviourits';
$route['products/get_products'] = 'front/ProductController/getProducts';
$route['cart/add-product-to-cart'] = 'front/CartController/addToCartProduct';
$route['cart/get-user-cart'] = 'front/CartController/getUserCartData';
$route['cart/delete-user-item'] = 'front/CartController/deleteUserCartItem';
$route['checkout'] = 'front/CheckoutController';
$route['checkout/order/place'] = 'front/CheckoutController/orderPlace';
$route['shop'] = 'front/ShopController/index';
$route['reviews/add-review'] = 'front/ReviewsController/addReview';
$route['shop/categories/(:any)'] = 'front/ShopController/categoryFilter/$1';
$route['shopping-cart'] = 'front/ShoppingCartController/shoppingCart';
$route['saveCartData'] = 'HomeController/saveCartData';
$route['cancel-order'] = 'front/OrderController/cancelOrder';
$route['subscription-plans'] = 'front/SubscriptionController/getPlanData';
$route['subscription-plans/update'] = 'front/SubscriptionController/updatePlanData';
