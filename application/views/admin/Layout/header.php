<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ECommerce</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<link rel="stylesheet" href="<?php echo base_url('public/assets/admin/plugins/fontawesome-free/css/all.min.css'); ?>">
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="<?php echo base_url('public/assets/admin/dist/css/adminlte.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('public/assets/admin/dist/css/custom.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('public/assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('public/assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
	
	<link rel="stylesheet" href="<?php echo base_url('public/assets/admin/plugins/ladda/ladda-themeless.min.css') ?>">
    <script src="<?php echo base_url('public/assets/admin/plugins/jquery/jquery.min.js') ?>"></script>
    <script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
    <script type="text/javascript">const baseUrl = "<?php echo base_url(); ?>";</script>
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="wrapper">
	<nav class="main-header navbar navbar-expand navbar-white navbar-light">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
			</li>
			<li class="nav-item d-none d-sm-inline-block">
				<a href="<?php echo base_url('admin/dashboard'); ?>" class="nav-link">Dashboard</a>
			</li>
		</ul>
	</nav>
	<aside class="main-sidebar sidebar-dark-primary elevation-4">
		<a href="<?php echo base_url('admin/dashboard'); ?>" class="brand-link">
			<span class="brand-text font-weight-light pl-2">ECommerce</span>
		</a>
		<div class="sidebar">
			<div class="user-panel mt-3 pb-3 mb-3 d-flex">
				<div class="image">
					<img src="<?php echo base_url('public/assets/admin/dist/img/user2-160x160.jpg'); ?>" class="img-circle elevation-2" alt="User Image">
				</div>
				<div class="info">
					<a href="#" class="d-block">Alexander Pierce</a>
					<a href="<?php echo base_url('admin/logOut'); ?>" class="d-block">LogOut</a>
				</div>
			</div>
			<nav class="mt-2">
				<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
					<li class="nav-item">
						<a href="<?php echo base_url('admin/dashboard'); ?>" class="nav-link" id="dashboard">
							<i class="nav-icon fas fa-tachometer-alt"></i>
							<p>Dashboard</p>
						</a>
					</li>
					<li class="nav-item">
                        <a href="<?php echo base_url('admin/users') ?>" id="UserList" class="nav-link">
                            <i class="nav-icon fa fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li>
					<li class="nav-item">
                        <a href="<?php echo base_url('admin/categories'); ?>" id="CategoriesList" class="nav-link">
                            <i class="nav-icon fa fa-sitemap"></i>
                            <p>Categories</p>
                        </a>
                    </li>
				</ul>
			</nav>
		</div>
	</aside>
