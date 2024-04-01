<?php

class MY_Controller extends CI_Controller 
{
	public function __construct() {
        parent::__construct();
    }

	public function render_template($page = null, $data = array())
	{   
		$this->load->view('front/Layout/header',$data);
		$this->load->view($page, $data);
		$this->load->view('front/Layout/footer',$data);
		$this->load->view('front/Layout/models',$data);
	}
}
