<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ECommerce</title>
	<link rel="shortcut icon" href="<?php echo base_url('images/favicon.png') ?>" type="image/x-icon" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<link rel="stylesheet" href="<?php echo base_url('public/assets/admin/plugins/fontawesome-free/css/all.min.css'); ?>">
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="<?php echo base_url('public/assets/admin/dist/css/adminlte.min.css'); ?>">
    	<link rel="stylesheet" href="<?php echo base_url('public/assets/admin/plugins/select2/select2.min.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('public/assets/admin/dist/css/custom.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('public/assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('public/assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('public/assets/admin/plugins/summernote/summernote-bs4.min.css') ?>">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
	<link rel="stylesheet" href="<?php echo base_url('public/assets/admin/plugins/ladda/ladda-themeless.min.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('public/assets/admin/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('public/assets/admin/plugins/daterangepicker/daterangepicker.css') ?>">
	
	<style type="text/css">
		.imagePreview{
			width:100%;
			height:140px;
			background-position:center center;
			background:url("<?php echo base_url('public/assets/admin/dist/img/default.jpeg'); ?>");
			background-color:#fff;
			background-size:cover;
			background-repeat:no-repeat;
			display:inline-block;
			background-position: center;
			box-shadow:0 -3px 6px 2px rgba(0,0,0,0.2)
		}
	</style>
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
			<nav class="mt-2">
				<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
					 <li class="nav-item has-treeview" id='profileTreeview' style="border-bottom: 1px solid #4f5962; margin-bottom: 4.5%;">
		                <a href="#" class="nav-link">
		                	<?php $userData = $this->session->get_userdata(); ?>
		                    <?php if (isset($userData['image']) && file_exists($userData['image'])) : ?>
		                        <img src=" <?php echo base_url($userData['image']) ?>" class="img-circle elevation-2" alt="User Image" style="width: 2.1rem; margin-right: 1.5%;">
		                    <?php else : ?>
		                        <img src="<?php echo base_url('public/assets/admin/dist/img/no-image.png') ?>" class="img-circle elevation-2" alt="User Image" style="width: 2.1rem; margin-right: 1.5%;">
		                    <?php endif ?>
		                    <p style="padding-right: 6.5%;">
							<?php echo isset($userData['first_name']) ? ucfirst($userData['first_name']) : '1'; ?>
		                        <i class="fa fa-angle-left right"></i>
		                    </p>
		                </a>
		                <ul class="nav nav-treeview">
		                    <li class="nav-item active">
		                        <?php $uId = isset($userData['id']) ? $userData['id'] : 0; ?>
		                        <a href="<?php echo base_url()."admin/profile/edit/".$uId ?>" class="nav-link" id="profileEdit">
		                            <i class="nav-icon fa fa-pencil"></i><p class="text-warning">Edit Profile</p>
		                        </a>
		                    </li>
		                    <li class="nav-item">
		                        <a href="<?php echo base_url('admin/logOut'); ?>" class="nav-link">
		                            <i class="nav-icon fa fa-sign-out"></i><p class="text-danger">Log out</p>
		                        </a>
		                    </li>
		                </ul>
		            </li>
					<li class="nav-item">
						<a href="<?php echo base_url('admin/dashboard'); ?>" class="nav-link" id="dashboard">
							<i class="nav-icon fas fa-tachometer-alt"></i>
							<p>Dashboard</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo base_url('admin/banners'); ?>" class="nav-link" id="bannerlist">
							<i class="nav-icon fa fa-images"></i>
							<p>Banners</p>
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
					<li class="nav-item">
                        <a href="<?php echo base_url('admin/settings/edit'); ?>" id="SettingsList" class="nav-link">
                            <i class="nav-icon fa fa-cog"></i>
                            <p>Settings</p>
						</a>
					</li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('admin/products'); ?>" id="productlist" class="nav-link">
                            <i class="nav-icon fa fa-tag"></i>
                            <p>Products</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('admin/contemt-management'); ?>" id="contentManagement" class="nav-link">
                            <i class="nav-icon fa fa-desktop"></i>
                            <p>Content Management</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('admin/contact-us'); ?>" id="contactUsManagement" class="nav-link">
                            <i class="nav-icon fa fa-envelope"></i>
                            <p>Contact Us</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('admin/subscription-plan'); ?>" id="subscriptionPlan" class="nav-link">
                            <i class="nav-icon fa fa-calendar-check"></i>
                            <p>Subscription Plans</p>
                        </a>
                    </li>
					<li class="nav-item has-treeview" id='reportTreeview' style="border-bottom: 1px solid #4f5962; margin-bottom: 4.5%;">
		                <a href="#" class="nav-link">
							<i class="nav-icon fa fa-flag"></i>
								<p>
									Reports
									<i class="fas fa-angle-left right"></i>
								</p>
		                </a>
		                <ul class="nav nav-treeview">
		                    <li class="nav-item active">
								<a href="<?php echo site_url('admin/reports/user_report'); ?>" class="nav-link" id="userReport">
										<i class="fas fa-file-alt nav-icon"></i>
										<p>User Orders Report</p>
									</a>
		                    </li>
		                    <li class="nav-item">
								<a href="<?php echo site_url('admin/reports/sales_report'); ?>" class="nav-link" id="salesReport">
										<i class="fas fa-chart-line nav-icon"></i>
										<p>Sales Report</p>
									</a>
		                    </li>
		                </ul>
		            </li>
				</ul>
			</nav>
		</div>
	</aside>
