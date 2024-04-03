<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
	}

	public function index() {
		$this->checkAdminLoggedIn();
		$this->adminRenderTemplate('admin/Dashboard/dashboardPage');
	}
}
