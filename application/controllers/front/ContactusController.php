<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ContactusController extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Contactus_model');
    }

	public function index() {
        $this->frontRenderTemplate('front/Contact/contactUs');
    }

    public function sendMessage() {
    	$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		$this->form_validation->set_rules('message', 'Message', 'required');


		if ($this->form_validation->run() == FALSE) {
			$this->frontRenderTemplate('front/Contact/contactUs');
			return $this;
		}

		$data = [
			'name' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'subject' => $this->input->post('subject'),
			'message' => $this->input->post('message'),
		];

		$create = $this->Contactus_model->create($data);
	
		if($create == true) {
			$this->session->set_flashdata('success', 'Thank you for getting in touch! We will get back in touch with you soon! Have a great day!.');
			redirect('contact', 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Error occurred!!');
			redirect('contact', 'refresh');
		}
    }

}