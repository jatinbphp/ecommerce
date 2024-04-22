<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyProfileController extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->checkUserLoggedIn();
        $this->load->model('User_model');
        $this->load->model('User_address_model');
    }

    public function edit() {
        $this->load->model('Categories_model');

        $selected_header_categories = [];
        $selected_footer_categories = [];

        if (isset($settings_data['header_menu_categories']) && $settings_data['header_menu_categories'] !== null) {
            $selected_header_categories = explode(',', $settings_data['header_menu_categories']);
        }

        if (isset($settings_data['footer_menu_categories']) && $settings_data['footer_menu_categories'] !== null) {
            $selected_footer_categories = explode(',', $settings_data['footer_menu_categories']);
        }
        
        if ($this->isLoggedIn()) {
            $userData = $this->session->userdata('user_data');
            if (is_array($userData)) {
                $userDataArray = $userData;
            } else {
                $userDataArray = get_object_vars($userData);
            }
            
            $this->load->library('form_validation');

            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('phone', 'Phone Number', 'required');
        
            $userId = $this->input->post('id');
            $imagePath = '';
        
            $this->load->library('upload');
        
            $config['upload_path'] = 'uploads/users/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = FALSE;
            $this->upload->initialize($config);
        
            if ($this->form_validation->run() == FALSE) {
                $data['userDataArray'] = $userDataArray;
                $data['title'] = "Profile Info";
                $data['selected_header_categories'] = $selected_header_categories;
                $data['selected_footer_categories'] = $selected_footer_categories;
                $this->frontRenderTemplate('front/myAccount/profile-info', $data);
            } else {
                $data = [
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'email' => $this->input->post('email'),
                    'phone' => $this->input->post('phone'),
                ];
    
                if ($this->upload->do_upload('image')) {
                    $uploadData = $this->upload->data();
                    $imagePath = 'uploads/users/' . $uploadData['file_name'];
                    $data['image'] = $imagePath;
                    $userData = $this->User_model->getUserData($userId);
        
                    if (!empty($userData['image']) && file_exists($userData['image'])) {
                        unlink($userData['image']);
                    }
                }
        
                if (!empty($this->input->post('categories_id'))) {
                    $data['categories_id'] = implode(',', $this->input->post('categories_id'));
                }
                $this->User_model->edit($data, $userId);
    
                $updatedUserData = (object) $this->User_model->getUserData($userId);
        
                $this->session->set_userdata('user_data', $updatedUserData);
                $this->session->set_flashdata('success', 'Profile updated successfully.');
        
                redirect('profile-info', 'refresh');
            }
        }
    }

    public function add_address() {
        if ($this->isLoggedIn()) {
            $userData = $this->session->userdata('user_data');
            if (is_array($userData)) {
                $userDataArray = $userData;
            } else {
                $userDataArray = get_object_vars($userData);
            }
        }
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', ' Last Name', 'required');
        $this->form_validation->set_rules('address_line1', 'Address', 'required');
        $this->form_validation->set_rules('mobile_phone', 'Mobile Number', 'required|numeric|min_length[10]');
        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('pincode', 'Pincode', 'required|numeric');
    
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Address";
            $data['userDataArray'] = $userDataArray;
            $this->frontRenderTemplate('front/myAccount/address/create', $data);
            return $this;
        } else {
            $userId = $this->input->post('id');
            $data = [
                'user_id' => $userId,
                'title' =>  !empty($this->input->post('title')) ? $this->input->post('title') : "",
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'mobile_phone' => $this->input->post('mobile_phone'),
                'state' => $this->input->post('state'),
                'city' => $this->input->post('city'),
                'country' => $this->input->post('country'),
                'pincode' => $this->input->post('pincode'),
                'address_line1' => $this->input->post('address_line1'),
                'company' => !empty($this->input->post('company')) ? $this->input->post('company') : "",
                'address_line2' => !empty($this->input->post('address_line2')) ? $this->input->post('address_line2') : "",
                'additional_information' => !empty($this->input->post('additional_information')) ? $this->input->post('additional_information') : "",
            ];

            $this->User_address_model->insert($data);
            $this->session->set_flashdata('success', 'Address added successfully.');
            redirect('profile-address', 'refresh');
        }
    }

    public function edit_address() {
        $data['title'] = "Address";
        $userDataArray = []; 

        if ($this->isLoggedIn()) {
            $userData = $this->session->userdata('user_data');
    
            if (is_array($userData)) {
                $userDataArray = $userData;
            } else {
                $userDataArray = get_object_vars($userData);
            }
            $this->load->model('User_address_model');
            $userAddresses = $this->User_address_model->getUserAddresses($userDataArray['id']);
            $data['userAddresses'] = $userAddresses;
        }
       
        $data['userDataArray'] = $userDataArray;
        $this->frontRenderTemplate('front/myAccount/address/index', $data);
    }

    public function edit_address_data($address_id) {
        if ($this->isLoggedIn()) {
            $userData = $this->session->userdata('user_data');

            if (is_array($userData)) {
                $userDataArray = $userData;
            } else {
                $userDataArray = get_object_vars($userData);
            }

            $this->load->model('User_address_model');
            $address_details = $this->User_address_model->getAddressDetails($address_id);
        }
        
        $this->load->library('form_validation');
       
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', ' Last Name', 'required');
        $this->form_validation->set_rules('address_line1', 'Address', 'required');
        $this->form_validation->set_rules('mobile_phone', 'Mobile Number', 'required|numeric|min_length[10]');
        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('pincode', 'Pincode', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $data['userDataArray'] = $userDataArray;
            $data['userAddresses'] = $address_details;
            $data['title'] = "Address";
            $this->frontRenderTemplate('front/myAccount/address/edit', $data);
        } else {
            $userId = $this->input->post('ids');
            $data = [
                'user_id' => $this->input->post('id'),
                'title' =>  !empty($this->input->post('title')) ? $this->input->post('title') : "",
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'mobile_phone' => $this->input->post('mobile_phone'),
                'state' => $this->input->post('state'),
                'city' => $this->input->post('city'),
                'country' => $this->input->post('country'),
                'pincode' => $this->input->post('pincode'),
                'address_line1' => $this->input->post('address_line1'),
                'company' => !empty($this->input->post('company')) ? $this->input->post('company') : "",
                'address_line2' => !empty($this->input->post('address_line2')) ? $this->input->post('address_line2') : "",
                'additional_information' => !empty($this->input->post('additional_information')) ? $this->input->post('additional_information') : "",
            ];

            $this->User_address_model->update_address($userId, $data);
            $this->session->set_flashdata('success', 'Address updated successfully.');
            redirect('profile-address', 'refresh');
        }
    }

    public function delete($id) {
        $deleted = $this->User_address_model->deleteAddress($id);

        if ($deleted) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete address']);
        }
    }

    public function edit_password() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('current_password', 'Current Password', 'required');
        $this->form_validation->set_rules('password', 'New Password', 'required|min_length[6]');
        $this->form_validation->set_rules('password_confirmation', 'Password Confirmation', 'required|matches[password]');
    
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "password";
            $this->frontRenderTemplate('front/myAccount/password/edit', $data);
            return $this;
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('password');
    
            if ($this->isLoggedIn()) {
                $userData = $this->session->userdata('user_data');
                if (is_array($userData)) {
                    $userDataArray = $userData;
                } else {
                    $userDataArray = get_object_vars($userData);
                }
    
                $stored_password = $userDataArray['password'];
                $userId = $userDataArray['id'];
    
                if (password_verify($current_password, $stored_password)) {
                    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $data['password'] = $hashed_new_password;
                    $this->User_model->edit($data, $userId);
                    $updatedUserData = $this->User_model->getUserData($userId);

                    $this->session->set_userdata('user_data', $updatedUserData);
                    $this->session->set_flashdata('success', 'Password updated successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Current password is incorrect.');
                }
            }
    
            redirect('change-password', 'refresh');
        }
    }
}
