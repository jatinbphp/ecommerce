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
        $this->checkAdminLoggedIn();
		$this->load->view('admin/Layout/header',$data);
		$this->load->view($page, $data);
		$this->load->view('admin/Layout/footer',$data);
	}

	public function adminRedirect() {
        $CI =& get_instance();
        if ($CI->session->userdata('admin_logged_in')) {
            redirect('admin/dashboard');
            exit;
        }
    }

	public function userRedirectIfLoggedIn() {
        $CI =& get_instance();
        if ($CI->session->userdata('logged_in')) {
            redirect(base_url());
            exit;
        }
    }

	public function getAdminData($email) {
        $CI =& get_instance();
        $adminData = $CI->user_model->getAdminData($email);
        return $adminData;
    }

	public function checkAdminLoggedIn() {
        $CI =& get_instance();
        if (!$CI->session->userdata('admin_logged_in')) {
            redirect('admin');
            exit;
        }
    }
}
