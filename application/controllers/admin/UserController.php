<?php

class UserController extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->checkAdminLoggedIn();
		$this->data['page_title'] = 'Users';
		$this->load->model('user_model');
		$this->load->model('countries_model');
	}

	public function index()
	{
		$this->adminRenderTemplate('admin/users/index', $this->data);
	}

	public function fetchUsers()
	{
		$data = [];
		$allData = $this->user_model->make_datatables();

		foreach ($allData as $row) {
			$usersData = [];
			$usersData[] = "#".$row->id;
			$usersData[] = $row->first_name;
			$usersData[] = $row->last_name;
			$usersData[] = $row->email;
			$usersData[] = $row->phone;
			$usersData[] = $this->getStatusButton($row->id, $row->status, 'users');
			$usersData[] = '<a href="' . base_url('admin/users/edit/' . $row->id) . '" class="btn btn-sm btn-warning"  style="margin-right:5px;"><i class="fa fa-edit"></i></a><a href="javascript:void(0);" class="btn btn-sm btn-danger deleteRecord" data-id="' . $row->id . '" data-controller="users" data-title="user"><i class="fa fa-trash"></i></a>';

			$data[] = $usersData;
		}
		$output = [
			"draw"            => intval($_POST["draw"]),
			"recordsTotal"    => $this->user_model->get_all_data(),
			"recordsFiltered" => $this->user_model->get_filtered_data(),
			"data"            => $data,
		];
		echo json_encode($output);
	}

	public function create()
	{
			$this->form_validation->set_rules('first_name', 'Name', 'required');
			$this->form_validation->set_rules('last_name', 'Name', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|matches[confirm_password]');
			$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required');	
			$this->form_validation->set_rules('mobileNo', 'Phone', 'required|numeric');
			$this->form_validation->set_rules('countryCode', '', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
	
			if ($this->form_validation->run() == FALSE) {

				// $error_messages = validation_errors();
				// print_r($error_messages);exit;
				$this->data['status'] = $this->user_model::$status;
				$getCountryCode = $this->countries_model->getCountryData();
				$this->data['countryCodes'] = $getCountryCode;				
				$this->adminRenderTemplate('admin/users/create', $this->data);
				return $this;
			}
        
			$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
			
			$data = [
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'password' => $password,
				'phone' => $this->input->post('mobileNo'),
				'email' => $this->input->post('email'),
				'role' => 2,
				'country_code' => $this->input->post('countryCode'),
				'status' => $this->input->post('status'),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			];


			$create = $this->user_model->addUserAndGetId($data);
			if($create > 0) {

				if (!empty($_FILES['userfile']['name'])) {

					$this->load->library('upload');
			        $config['upload_path'] = 'uploads/users/';
			        $config['allowed_types'] = 'gif|jpg|png';
			        $config['max_size'] = 2048;
			        $config['encrypt_name'] = FALSE; 
			        $this->upload->initialize($config);
			    
			        if ($this->upload->do_upload('userfile')) {
			            $uploadData = $this->upload->data();
			            $imagePath = 'uploads/users/' . $uploadData['file_name'];
			            $this->user_model->updateUserImage($create,$imagePath);
			        } 
				}

				$this->session->set_flashdata('success', 'User has been inserted successfully! Please add user addresses.');
				redirect('admin/users/edit/'.$create, 'refresh');
			}
			else {
				$this->session->set_flashdata('error', $this->lang->line('lang_error_occurred'));
				redirect('admin/users/create', 'refresh');
			}
	}
	
	public function edit($id = null)
	{
		if($id) {

			$this->form_validation->set_rules('first_name', 'Name', 'required');
			$this->form_validation->set_rules('last_name', 'Name', 'required');
			
			$this->form_validation->set_rules('mobileNo', 'Phone', 'required|numeric');
			$this->form_validation->set_rules('countryCode', '', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

			if ($this->form_validation->run() == FALSE) {
				$usersData = $this->user_model->getUserData($id);
				$this->data['userData'] = $usersData;
				$this->data['status'] = $this->user_model::$status;
				$getCountryCode = $this->countries_model->getCountryData();
				$this->data['countryCodes'] = $getCountryCode;
				$this->adminRenderTemplate('admin/users/create', $this->data);
				return;
			}


			if(($this->input->post('first_name')!='') && ($this->input->post('last_name')!='') && ($this->input->post('mobileNo')!='') && ($this->input->post('email')!='')){

				//process images
				if (!empty($_FILES['userfile']['name'])) {

					$getUsrImg = $this->user_model->getUserData($id);
					if(isset($getUsrImg['image']))
					{
						if (file_exists($getUsrImg['image'])) {
							unlink($getUsrImg['image']);
						}
					}

					$this->load->library('upload');
			        $config['upload_path'] = 'uploads/users/';
			        $config['allowed_types'] = 'gif|jpg|png';
			        $config['max_size'] = 2048;
			        $config['encrypt_name'] = FALSE; 
			        $this->upload->initialize($config);
			    
			        if ($this->upload->do_upload('userfile')) {
			            $uploadData = $this->upload->data();
			            $imagePath = 'uploads/users/' . $uploadData['file_name'];
			            $this->user_model->updateUserImage($id,$imagePath);
			        } 
				}

				// true case
				if(empty($this->input->post('password')) && empty($this->input->post('confirm_password'))) {
					$data = [
						'first_name' => $this->input->post('first_name'),
						'last_name' => $this->input->post('last_name'),
						'phone' => $this->input->post('mobileNo'),
						'email' => $this->input->post('email'),
						'role' => 2,
						'country_code' => $this->input->post('countryCode'),
						'status' => $this->input->post('status'),
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),
					];

					$update = $this->user_model->edit($data, $id);
					if($update == true) {
						$this->session->set_flashdata('success','The Record is successfully updated');
						redirect(base_url('admin/users'));
					}
					else {
						$this->session->set_flashdata('error', 'Something went wrong');
						redirect('admin/users/edit/'.$id, 'refresh');
					}
				}
				else {

					$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|matches[confirm_password]');
					$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required');	

					if ($this->form_validation->run() == FALSE) {
						$usersData = $this->user_model->getUserData($id);
						$this->data['userData'] = $usersData;
						$this->data['status'] = $this->user_model::$status;
						$getCountryCode = $this->countries_model->getCountryData();
						$this->data['countryCodes'] = $getCountryCode;
						$this->adminRenderTemplate('admin/users/create', $this->data);
						return;
					}

					$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

					$data = [
						'first_name' => $this->input->post('first_name'),
						'last_name' => $this->input->post('last_name'),
						'password' => $password,
						'phone' => $this->input->post('mobileNo'),
						'email' => $this->input->post('email'),
						'role' => 2,
						'country_code' => $this->input->post('countryCode'),
						'status' => $this->input->post('status'),
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),
					];

					$update = $this->user_model->edit($data, $id);
					if($update == true) {
						$this->session->set_flashdata('success','The Record is successfully updated');
						redirect(base_url('admin/users'));
					}
					else {
						$this->session->set_flashdata('error', 'Error Occured');
						redirect('admin/users/edit/'.$id, 'refresh');
					}
				}
			} else {
				$usersData = $this->user_model->getUserData($id);
				$this->data['userData'] = $usersData;
				$this->data['status'] = $this->user_model::$status;
				$getCountryCode = $this->countries_model->getCountryData();
				$this->data['countryCodes'] = $getCountryCode;
				$this->adminRenderTemplate('admin/users/create', $this->data);
			}
		}
	}

	public function delete($id)
	{

		if($id) {
			$data = array(
				'deleted' => 1
			);
			//$update = $this->user_model->edit($data, $id);
			$update = $this->user_model->edit_application($data, $id);
			$delete = $this->user_model->delete($id);
			if($update == true) {
				$this->session->set_flashdata('success', $this->lang->line('lang_successfully_removed_applicants'));
				redirect('students', 'refresh');
			}
			else {
				$this->session->set_flashdata('error', $this->lang->line('lang_error_occurred'));
				redirect('students'.$id, 'refresh');
			}

		}
	}

	public function check_username_exist()
	{
		$username = $this->input->post('username');
		if($username != ''){
			$data['username']=$this->user_model->check_username_exist($username);

			$return = '';
			if($data['username'] == 'Yes'){
				$return = false;
			} else {
				$return = true;
			}

			echo json_encode($return);
			exit();
		}
	}
}
