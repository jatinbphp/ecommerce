<?php

$route['admin'] = 'admin/AdminController';
$route['admin/dashboard'] = 'admin/DashboardController';
$route['admin/users'] = 'admin/UserController';
$route['admin/users/create'] = 'admin/UserController/create';
$route['admin/users/fetch_users'] = 'admin/UserController/fetch_users';
$route['admin/categories'] = 'admin/CategoriesController';
$route['admin/categories/create'] = 'admin/CategoriesController/create';
$route['admin/categories/edit/(:num)'] = 'admin/CategoriesController/edit/$1';
$route['admin/categories/fetch_categories'] = 'admin/CategoriesController/fetch_categories';
$route['admin/categories/delete/(:num)'] = 'admin/CategoriesController/delete/$1';