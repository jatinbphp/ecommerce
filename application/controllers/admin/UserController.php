<?php

class UserController extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->checkAdminLoggedIn();
		$this->data['page_title'] = 'Users';
		$this->load->model('user_model');
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
		$this->form_validation->set_rules('phone', 'Phone', 'required|numeric');
		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
	
	    if ($this->form_validation->run() == FALSE) {
        	$this->data['status'] = $this->user_model::$status;
			$this->adminRenderTemplate('admin/users/create', $this->data);
        	return $this;
        }
        
		$password = md5($this->input->post('password'));
		$data = [
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'password' => $password,
			'phone' => $this->input->post('phone'),
			'email' => $this->input->post('email'),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
		];

		$create = $this->user_model->create($data);
		if($create == true) {
	        $config['upload_path']   = './uploads/users/';
	        $config['allowed_types'] = '*';
	        $config['overwrite']     = TRUE; // overwrite if file with same name already exists

	        $this->load->library('upload', $config);
			$this->session->set_flashdata('success', 'User has been inserted successfully! Please add user addresses.');
			redirect('admin/users/edit', 'refresh');
		}
		else {
			$this->session->set_flashdata('error', $this->lang->line('lang_error_occurred'));
			redirect('admin/users/create', 'refresh');
		}

	}
	
	public function edit($id = null)
	{
		if($id) {
			if(($this->input->post('firstname')!='') && ($this->input->post('lastname')!='') && ($this->input->post('phone')!='') && ($this->input->post('email')!='') && ($this->input->post('username')!='')){

				// true case
				if(empty($this->input->post('password')) && empty($this->input->post('cpassword'))) {
					$data = array(
						'username' => $this->input->post('username'),
						'email' => $this->input->post('email'),
						'firstname' => $this->input->post('firstname'),
						'lastname' => $this->input->post('lastname'),
						'phone' => $this->input->post('phone'),
						'status' => $this->input->post('status'),
					);

					$update = $this->user_model->edit($data, $id);
					if($update == true) {
						$this->session->set_flashdata('success', $this->lang->line('lang_successfully_updated_applicants'));
						redirect('students', 'refresh');
					}
					else {
						$this->session->set_flashdata('error', $this->lang->line('lang_error_occurred'));
						redirect('admin/users/edit/'.$id, 'refresh');
					}
				}
				else {

					$password = md5($this->input->post('password'));

					$data = [
						'username' => $this->input->post('username'),
						'password' => $password,
						'email' => $this->input->post('email'),
						'firstname' => $this->input->post('firstname'),
						'lastname' => $this->input->post('lastname'),
						'phone' => $this->input->post('phone'),
						'status' => $this->input->post('status'),
					];

					$update = $this->user_model->edit($data, $id);
					if($update == true) {
						$this->session->set_flashdata('success', $this->lang->line('lang_successfully_updated_applicants'));
						redirect('students', 'refresh');
					}
					else {
						$this->session->set_flashdata('error', $this->lang->line('lang_error_occurred'));
						redirect('admin/users/edit/'.$id, 'refresh');
					}
				}
			} else {
				$usersData = $this->user_model->getUserData($id);
				$this->data['user_data'] = $usersData;
				$this->data['status'] = $this->user_model::$status;
				$this->adminRenderTemplate('admin/users/edit', $this->data);
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
