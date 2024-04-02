<?php

class MY_Controller extends CI_Controller 
{
	public function __construct() {
        parent::__construct();
    }

	public function frontRenderTemplate($page = null, $data = array())
	{   
		$this->load->view('front/Layout/header',$data);
		$this->load->view($page, $data);
		$this->load->view('front/Layout/footer',$data);
		$this->load->view('front/Layout/models',$data);
	}

	public function adminRenderTemplate($page = null, $data = array())
	{
		$this->load->view('admin/Layout/header',$data);
		$this->load->view($page, $data);
		$this->load->view('admin/Layout/footer',$data);
	}

	public function loggedIn()
	{
		$session_data = $this->session->userdata();
		if($session_data['logged_in'] == TRUE) {
			unset($_SESSION['admin_loggedin']);
			redirect('dashboard', 'refresh');
		}
	}

	public function notLoggedIn()
	{
		$session_data = $this->session->userdata();
		if($session_data['logged_in'] == FALSE) {
			$this->session->sess_destroy();
			redirect('admin/login', 'refresh');
		}
	}
}
