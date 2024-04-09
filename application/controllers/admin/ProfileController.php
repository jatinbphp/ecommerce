<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ProfileController extends MY_Controller
{
	protected $_data = [];

	public function __construct(){
		parent::__construct();
		$this->checkAdminLoggedIn();
		$this->data['page_title'] = 'Profile';
		$this->load->model('user_model');
	}

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

			if($path = $this->uploadAndgetPath()){
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
				$adminData = $this->getAdminData($this->input->post('email'));
	            unset($adminData['password']);
	            $adminData['admin_logged_in'] = 'true';
	            $this->session->set_userdata($adminData);
				$this->session->set_flashdata('success', 'Profile has been updated successfully!');
				redirect('admin/dashboard', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Error occurred!!');
				redirect('admin/profile/edit/'.$id, 'refresh');
			}
		}
	}

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

	public function uploadAndgetPath() {
	    if (!empty($_FILES['image']['name'])) {
	        $this->load->library('upload');

	        $config['upload_path'] = 'uploads/users/';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size'] = 106610;
			$config['encrypt_name'] = TRUE; // Change to TRUE for security reasons

	        $this->upload->initialize($config);

	        if ($this->upload->do_upload('image')) {
	            $uploadData = $this->upload->data();
	            $imagePath = 'uploads/users/' . $uploadData['file_name'];

	            return $imagePath;
	        } else {
	        	$this->upload->display_errors();
	        	//return $this->upload->display_errors();
	            return '';
	        }
	    } else {
	        return '';
	    }
	}
}
