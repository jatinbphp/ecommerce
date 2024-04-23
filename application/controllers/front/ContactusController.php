<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* This class extends the MY_Controller class and likely handles contact us functionality. */
class ContactusController extends MY_Controller {

	/**
	 * The above PHP function is a constructor that loads the Contactus_model in the parent class.
	 */
	public function __construct() {
        parent::__construct();
        $this->load->model('Contactus_model');
    }

	/**
	 * The index function loads settings data from the database and renders a contact us template for the
	 * front end.
	 */
	public function index() {
		$this->load->model('Settings_model');
		$settingsData = $this->Settings_model->getSettingsById(1);
		$data['settingsData']= $settingsData;
        $this->frontRenderTemplate('front/Contact/contactUs', $data);
    }

    /**
	 * The function `sendMessage` validates and processes a contact form submission, storing the data
	 * in the database and displaying success or error messages accordingly.
	 * 
	 */
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