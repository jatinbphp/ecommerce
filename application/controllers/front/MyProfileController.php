<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MyProfileController class extends MY_Controller.
 *
 * This class serves as a controller for managing user profiles. It inherits properties and methods from MY_Controller.
 */
class MyProfileController extends MY_Controller {

    /**
     * Constructor for the class.
     * It initializes the parent class and loads the User_model and User_address_model.
     * It also checks if the user is logged in.
     */
    public function __construct() {
        parent::__construct();
        $this->checkUserLoggedIn();
        $this->load->model('User_model');
        $this->load->model('User_address_model');
    }

    /**
     * Edit the user profile information after validating the input data.
     * 
     * This method checks if the user is logged in, loads necessary models and libraries,
     * validates the input data for first name, last name, email, and phone number.
     * If validation fails, it renders the profile info view with the user data.
     * If validation passes, it updates the user data, including uploading a new image if provided.
     * Finally, it updates the session data with the new user information and redirects to the profile info page.
     * 
     * @return $this
     */
    public function edit() {
        $this->checkUserLoggedIn();
        $this->load->model('Categories_model');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required');
        
        $userData = $this->session->userdata();
        $userId   = $this->session->userdata('userId');
        
        if ($this->form_validation->run() == FALSE) {
            $data['userDataArray'] = $userData;
            $data['title'] = "Profile Info";
            $this->frontRenderTemplate('front/myAccount/profile-info', $data);
            return $this;
        }

        $data = [
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
        ];

        $this->load->library('upload');
        $config['upload_path'] = 'uploads/users/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = FALSE;
        $this->upload->initialize($config);

        $userData = $this->User_model->getUserData($userId);

        if ($this->upload->do_upload('image')) {
            $uploadData = $this->upload->data();
            $imagePath = 'uploads/users/' . $uploadData['file_name'];
            $data['image'] = $imagePath;
            if (!empty($userData['image']) && file_exists($userData['image'])) {
                unlink($userData['image']);
            }
        }

        $this->User_model->edit($data, $userId);

        $updatedUserData = (object) $this->User_model->getUserData($userId);
        unset($updatedUserData['password']);
	    $updatedUserData['logged_in'] = 'true';
        $this->session->set_userdata('user_data', $updatedUserData);
        $this->session->set_flashdata('success', 'Profile updated successfully.');

        redirect('profile-info', 'refresh');
    }

    /**
     * Adds a new address for the logged-in user.
     * Validates the input fields for the address form and inserts the address into the database.
     * If validation fails, it reloads the address creation form with error messages.
     *
     * @return $this
     */
    public function add_address() {
        $this->checkUserLoggedIn();    
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', ' Last Name', 'required');
        $this->form_validation->set_rules('address_line1', 'Address', 'required');
        $this->form_validation->set_rules('mobile_phone', 'Mobile Number', 'required|numeric|min_length[10]');
        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('pincode', 'Pincode', 'required|numeric');
        
        $userData = $this->session->userdata();
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Address";
            $data['userDataArray'] = $userData;
            $this->frontRenderTemplate('front/myAccount/address/create', $data);
            return $this;
        }

        $userId   = $this->session->userdata('userId');
        
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

    /**
     * Edit the user's address by rendering the address edit form.
     * 
     * This method first checks if the user is logged in. It then retrieves the user's addresses
     * and user data based on the logged-in user's ID. Finally, it renders the address edit form
     * template with the retrieved data.
     */
    public function edit_address() {
        $this->checkUserLoggedIn();
        
        $data['title'] = "Address";
        $userId        = $this->session->userdata('userId');
        
        $data['userAddresses'] = $this->User_address_model->getUserAddresses($userId);
        $data['userDataArray'] =  $this->User_model->getUserData($userId);
        $this->frontRenderTemplate('front/myAccount/address/index', $data);
    }

    /**
     * Edit the address data for the given address ID.
     * Validates the form fields for editing address details and updates the address data in the database.
     * If validation fails, it loads the edit address form with error messages.
     *
     * @param int $address_id The ID of the address to be edited
     * @return $this
     */
    public function edit_address_data($address_id) {
        $this->checkUserLoggedIn();

        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', ' Last Name', 'required');
        $this->form_validation->set_rules('address_line1', 'Address', 'required');
        $this->form_validation->set_rules('mobile_phone', 'Mobile Number', 'required|numeric|min_length[10]');
        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('pincode', 'Pincode', 'required|numeric');

        $userData = $this->session->userdata();
        $address_details = $this->User_address_model->getAddressDetails($address_id);

        if ($this->form_validation->run() == FALSE) {
            $data['userDataArray'] = $userData;
            $data['userAddresses'] = $address_details;
            $data['title'] = "Address";
            $this->frontRenderTemplate('front/myAccount/address/edit', $data);
            return $this;
        }

        $userId = $this->session->userdata('userId');
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

    /**
     * Delete an address by its ID.
     *
     * @param int $id The ID of the address to delete
     * @return void
     */
    public function delete($id) {
        $deleted = $this->User_address_model->deleteAddress($id);
        header('Content-Type: application/json');
        if ($deleted) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete address']);
        }
    }

    /**
     * Allows the logged-in user to edit their password.
     * Validates the current password, new password, and password confirmation.
     * If validation fails, it renders the password edit form.
     * If validation passes, it updates the user's password in the database.
     * 
     * @return $this
     */
    public function edit_password() {
        $this->checkUserLoggedIn();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('current_password', 'Current Password', 'required');
        $this->form_validation->set_rules('password', 'New Password', 'required|min_length[6]');
        $this->form_validation->set_rules('password_confirmation', 'Password Confirmation', 'required|matches[password]');
    
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Password";
            $this->frontRenderTemplate('front/myAccount/password/edit', $data);
            return $this;
        }

        $current_password = $this->input->post('current_password');
        $new_password     = $this->input->post('password');

        $userId   = $this->session->userdata('userId');
        $userData = $this->User_model->getUserData($userId);

        $stored_password = $userData['password'];

        if (password_verify($current_password, $stored_password)) {
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $data['password'] = $hashed_new_password;
            $this->User_model->edit($data, $userId);
            $updatedUserData = $this->User_model->getUserData($userId);
            $this->session->set_flashdata('success', 'Password updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Current password is incorrect.');
        }
        redirect('change-password', 'refresh');
    }
}
