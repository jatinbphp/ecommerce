<?php

$route['admin/logIn'] = 'admin/AdminController/logIn';
$route['admin/logOut'] = 'admin/AdminController/logout';
$route['admin'] = 'admin/AdminController';
$route['admin/update-status'] = 'admin/AdminController/updateStatus';
$route['admin/dashboard'] = 'admin/DashboardController';
$route['admin/users'] = 'admin/UserController';
$route['admin/users/create'] = 'admin/UserController/create';
$route['admin/users/edit/(:num)'] = 'admin/UserController/edit/$1';
$route['admin/users/fetch_users'] = 'admin/UserController/fetchUsers';
$route['admin/categories'] = 'admin/CategoriesController';
$route['admin/categories/create'] = 'admin/CategoriesController/create';
$route['admin/categories/edit/(:num)'] = 'admin/CategoriesController/edit/$1';
$route['admin/categories/fetch_categories'] = 'admin/CategoriesController/fetchCategories';
$route['admin/categories/delete/(:num)'] = 'admin/CategoriesController/delete/$1';
$route['admin/banners'] = 'admin/BannerController';
$route['admin/banners/create'] = 'admin/BannerController/create';
$route['admin/banners/edit/(:num)'] = 'admin/BannerController/edit/$1';
$route['admin/banners/show/(:num)'] = 'admin/BannerController/show/$1';
$route['admin/banners/delete/(:num)'] = 'admin/BannerController/delete/$1';
$route['admin/banners/fetch_banners'] = 'admin/BannerController/fetchBanners';
