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
$route['contact'] = 'HomeController/contactPage';