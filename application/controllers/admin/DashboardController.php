<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * DashboardController class extends MY_Controller.
 *
 * This class serves as the controller for the dashboard functionality of the application.
 * It inherits properties and methods from the MY_Controller class.
 */
class DashboardController extends MY_Controller {

 /**
  * Constructor method for the class.
  * It initializes the parent constructor, checks if the admin is logged in,
  * loads the user_model, and checks if the admin is logged in again.
  */
	public function __construct() {
		parent::__construct();
		$this->checkAdminLoggedIn();
		$this->load->model('user_model');
		$this->checkAdminLoggedIn();
	}

 /**
  * Render the dashboard page for the admin.
  */
	public function index() {
		$this->adminRenderTemplate('admin/Dashboard/dashboardPage');
	}
}
