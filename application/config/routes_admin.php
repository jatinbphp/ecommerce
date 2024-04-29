<?php
$route['admin/logIn'] = 'admin/AdminController/logIn';
$route['admin/logOut'] = 'admin/AdminController/logout';
$route['admin'] = 'admin/AdminController';
$route['admin/update-status'] = 'admin/AdminController/updateStatus';
$route['admin/dashboard'] = 'admin/DashboardController';
$route['admin/users'] = 'admin/UserController';
$route['admin/users/create'] = 'admin/UserController/create';
$route['admin/users/edit/(:num)'] = 'admin/UserController/edit/$1';
$route['admin/users/show/(:num)'] = 'admin/UserController/show/$1';
$route['admin/users/delete/(:num)'] = 'admin/UserController/delete/$1';
$route['admin/users/fetch_users'] = 'admin/UserController/fetchUsers';
$route['admin/profile/edit/(:num)'] = 'admin/ProfileController/edit/$1';
$route['admin/categories'] = 'admin/CategoriesController';
$route['admin/categories/create'] = 'admin/CategoriesController/create';
$route['admin/categories/edit/(:num)'] = 'admin/CategoriesController/edit/$1';
$route['admin/categories/show/(:num)'] = 'admin/CategoriesController/show/$1';
$route['admin/categories/fetch_categories'] = 'admin/CategoriesController/fetchCategories';
$route['admin/categories/delete/(:num)'] = 'admin/CategoriesController/delete/$1';
$route['admin/products'] = 'admin/ProductController';
$route['admin/products/create'] = 'admin/ProductController/create';
$route['admin/products/edit/(:num)'] = 'admin/ProductController/edit/$1';
$route['admin/product/removeimage'] = 'admin/ProductController/removeimage';
$route['admin/products/show/(:num)'] = 'admin/ProductController/show/$1';
$route['admin/products/fetch_products'] = 'admin/ProductController/fetchProducts';
$route['admin/products/delete/(:num)'] = 'admin/ProductController/delete/$1';
$route['admin/products/show/(:num)'] = 'admin/ProductController/show/$1';
$route['admin/products/reviews/(:num)'] = 'admin/ProductController/productReviews/$1';
$route['admin/products/fetch_reviews/(:num)'] = 'admin/ProductController/fetchReviews/$1';
$route['admin/banners'] = 'admin/BannerController';
$route['admin/banners/create'] = 'admin/BannerController/create';
$route['admin/banners/edit/(:num)'] = 'admin/BannerController/edit/$1';
$route['admin/banners/show/(:num)'] = 'admin/BannerController/show/$1';
$route['admin/banners/delete/(:num)'] = 'admin/BannerController/delete/$1';
$route['admin/banners/fetch_banners'] = 'admin/BannerController/fetchBanners';
$route['admin/settings/edit'] = 'admin/SettingsController/edit';
$route['admin/settings/update'] = 'admin/SettingsController/update';
$route['admin/contemt-management'] = 'admin/ContentManagementController';
$route['admin/contemt-management/edit/(:num)'] = 'admin/ContentManagementController/edit/$1';
$route['admin/contemt-management/fetch_content'] = 'admin/ContentManagementController/fetchContent';
$route['admin/contemt-management/show/(:num)'] = 'admin/ContentManagementController/show/$1';
$route['admin/contact-us'] = 'admin/ContactusController';
$route['admin/contact-us/delete/(:num)'] = 'admin/ContactusController/delete/$1';
$route['admin/contact-us/show/(:num)'] = 'admin/ContactusController/show/$1';
$route['admin/contact-us/fetch_contactus'] = 'admin/ContactusController/fetchContactUs';
$route['admin/user/deleteAddress'] = 'admin/UserController/deleteAddress';
/*subscription-plan*/
$route['admin/subscription-plan'] = 'admin/SubscriptionPlanController';
$route['admin/subscription-plan/create'] = 'admin/SubscriptionPlanController/create';
$route['admin/subscription-plan/edit/(:num)'] = 'admin/SubscriptionPlanController/edit/$1';
$route['admin/subscription-plan/delete/(:num)'] = 'admin/SubscriptionPlanController/delete/$1';
$route['admin/subscription-plan/fetch_subscription_plan'] = 'admin/SubscriptionPlanController/fetchSubscriptionPlan';
