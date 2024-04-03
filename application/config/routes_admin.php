<?php

$route['admin/logIn'] = 'admin/AdminController/logIn';
$route['admin/logOut'] = 'admin/AdminController/logout';
$route['admin'] = 'admin/AdminController';
$route['admin/update-status'] = 'admin/AdminController/updateStatus';
$route['admin/dashboard'] = 'admin/DashboardController';
$route['admin/users'] = 'admin/UserController';
$route['admin/users/create'] = 'admin/UserController/create';
$route['admin/users/fetch_users'] = 'admin/UserController/fetch_users';
$route['admin/categories'] = 'admin/CategoriesController';
$route['admin/categories/create'] = 'admin/CategoriesController/create';
$route['admin/categories/edit/(:num)'] = 'admin/CategoriesController/edit/$1';
$route['admin/categories/fetch_categories'] = 'admin/CategoriesController/fetchCategories';
$route['admin/categories/delete/(:num)'] = 'admin/CategoriesController/delete/$1';
