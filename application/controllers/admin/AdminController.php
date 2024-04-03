<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index() {
        $this->adminRedirect();
        $this->load->view('admin/auth/signIn');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('admin');
    }

    public function logIn() {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        if ($this->form_validation->run() == FALSE) {
            $error_messages = validation_errors();
            $this->session->set_flashdata('error', $error_messages);
            redirect('admin');
        }

        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $adminUser = $this->user_model->authenticate($email, $password, 1);    

        if ($adminUser) {
            $getAdminData = $this->getAdminData($this->input->post('email'));
            $getAdminData['admin_logged_in'] = 'true';
            $this->session->set_userdata($getAdminData);
            redirect('admin/dashboard');
        }
        else    
        {
            $this->session->set_flashdata('error', 'Your Email or Password is wrong,Please check your email and password');   
            redirect('admin');
        }        
    }

}