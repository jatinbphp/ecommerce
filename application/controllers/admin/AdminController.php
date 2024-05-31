<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* This class extends the MY_Controller class and likely contains methods and properties specific to
administrative tasks. */
class AdminController extends MY_Controller {
    /**
     * The above function is a constructor in a PHP class that loads the user_model.
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    /**
     * The index function redirects to the admin page and loads the sign-in view.
     */
    public function index() {
        $this->adminRedirect();
        $this->load->view('admin/auth/signIn');
    }

    /**
     * The function logs out the user by destroying the session and redirecting to the admin page.
     */
    public function logout() {
        $this->session->sess_destroy();
        redirect('admin');
    }

    /**
     * The logIn function validates user input, authenticates admin credentials, and sets session data
     * accordingly.
     */
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
            $adminData = $this->getAdminData($this->input->post('email'));
            unset($adminData['password']);
            $adminData['admin_logged_in'] = 'true';
            $this->session->set_userdata($adminData);
            redirect('admin/dashboard');
        } else{
            $this->session->set_flashdata('error', 'Your Email or Password is wrong,Please check your email and password');   
            redirect('admin');
        }
       
    }

    /**
     * The function `updateStatus` updates the status of a record in a database table based on input
     * parameters.
     */
    public function updateStatus()
    {
        $id = $this->input->post('id');
        $tableName = $this->input->post('table_name');
        $type = $this->input->post('type');
        
        if($id && $tableName && $type){
            $data = ['status' => ($type == 'unassign') ? 'inactive' : 'active'];
            if($tableName == 'users'){
                $data['login_attempts'] = 0;
            }
            $this->db->where('id', $id);
            $this->db->update($tableName, $data);
        }
    }

    public function load404(){
        $this->adminRenderTemplate('admin/error-404');
    }
}