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
$route['shop'] = 'HomeController/shopPage';
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
$route['payment'] = 'front/PaymentController';
$route['payment/process-payment'] = 'front/PaymentController/processPayment';

