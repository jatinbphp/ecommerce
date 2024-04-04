<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->checkAdminLoggedIn();
		$this->load->model('user_model');
		$this->checkAdminLoggedIn();
	}

	public function index() {
		$this->adminRenderTemplate('admin/Dashboard/dashboardPage');
	}
}
