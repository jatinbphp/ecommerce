<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ProfileController class extends MY_Controller.
 * This controller is responsible for handling profile-related functionalities.
 */
class ProfileController extends MY_Controller
{
	protected $_data = [];

	/**
	 * Constructor for the ProfileController class.
	* Initializes the parent constructor.
	* Checks if the admin is logged in.
	* Sets the page title to 'Profile'.
	* Loads the 'user_model'.
	*/
	public function __construct(){
		parent::__construct();
		$this->checkAdminLoggedIn();
		$this->data['page_title'] = 'Profile';
		$this->load->model('user_model');
	}

	/**
	 * Edit user profile based on the provided ID.
	*
	* @param int|null $id The ID of the user profile to edit
	* @return $this
	*/
	public function edit($id = null){
		if($id) {
			$this->form_validation->set_rules('first_name', 'First Name', 'required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('image', 'Image', 'callback_validate_image');

			if ($this->form_validation->run() == FALSE) {
	        	$this->data['userData'] = $this->session->get_userdata();
				$this->data['status'] = $this->user_model::$status;
				$this->adminRenderTemplate('admin/Profile/editProfile', $this->data);
				return $this;
	        }

			/**
			 * Validates the password and confirmation password fields.
			* If the password field is not empty, it sets validation rules for password and confirmation password.
			* If the form validation fails, it retrieves user data, status, and renders the editProfile template for the admin.
			*
			* @return $this
			*/
	        if(!empty($this->input->post('password'))){
	        	$this->form_validation->set_rules('password', 'Password', ['required', 'min_length[6]', 'matches[confirm_password]']);
				$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required');

				if ($this->form_validation->run() == FALSE) {
					$this->data['userData'] = $this->session->get_userdata();
					$this->data['status'] = $this->user_model::$status;
					$this->adminRenderTemplate('admin/Profile/editProfile', $this->data);
					return $this;
				}
	        }

			$data = [
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'email' => $this->input->post('email'),
			];

			if(!empty($this->input->post('password'))){
				$data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
			}

			/**
			* Uploads a file and gets the file path. If successful, updates the 'image' key in the data array with the new path.
			* If the user data row contains an 'image' key, the existing file is deleted before updating the path.
			*/
			if($path = $this->uploadFile('uploads/users', $_FILES)){
				$data['image'] = $path;
				$userDataRow = $this->user_model->getAdminUserData($id);
				if(isset($userDataRow['image'])){
					if (file_exists($userDataRow['image'])) {
						unlink($userDataRow['image']);
					}
				}
			}

			$update = $this->user_model->edit($data, $id);

			if($update == true) {
				/**
				 * Retrieves the admin data based on the provided email from the input post data.
				 * Removes the 'password' field from the admin data.
				 * Sets the 'admin_logged_in' field to 'true' in the admin data.
				 * Sets the admin data to the session.
				 * Sets a flash message 'success' with the message 'Profile has been updated successfully!' to the session.
				 * Redirects to the 'admin/dashboard' page with a refresh.
				 */
				$adminData = $this->getAdminData($this->input->post('email'));
	            unset($adminData['password']);
	            $adminData['admin_logged_in'] = 'true';
	            $this->session->set_userdata($adminData);
				$this->session->set_flashdata('success', 'Profile has been updated successfully!');
				redirect('admin/dashboard', 'refresh');
			} else {
				/**
				 * Sets a flash data message with the key 'error' and the value 'Error occurred!!' in the session.
				 * Redirects the user to the 'admin/profile/edit/{id}' page with a 'refresh' method.
				 */
				$this->session->set_flashdata('error', 'Error occurred!!');
				redirect('admin/profile/edit/'.$id, 'refresh');
			}
		}
	}

	/**
	 * Validate the uploaded image file.
	*
	* This method checks if the uploaded image file meets the required criteria.
	*
	* @param  mixed  $image
	* @return bool  Returns true if the image is valid, false otherwise.
	*/
	public function validate_image($image) {
	    if (empty($_FILES['image']['name'])) {
	        // $this->form_validation->set_message('validate_image', 'The {field} field is required.');
	        return true;
	    } else {
	        $allowed_types = ['jpeg', 'jpg', 'png'];
	        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
	        if (!in_array(strtolower($ext), $allowed_types)) {
	            $this->form_validation->set_message('validate_image', 'The {field} must be a valid JPEG, JPG, or PNG file.');
	            return false;
	        }
	    }
	    return true;
	}
}
