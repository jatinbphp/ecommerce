<?php

class UserController extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->data['page_title'] = $this->lang->line('lang_page_title_applicant');
		$this->load->model('user_model');

//		if($this->session->userdata('role')!='1'){
//			$this->session->set_flashdata('error', $this->lang->line('lang_error_not_authorised_section'));
//			redirect('dashboard', 'refresh');
//		}
	}

	public function index()
	{
		$user_data = $this->user_model->getUserData();
		$result_info = array();
		foreach ($user_data as $k => $v) {
			$result_info[$k]['users_info'] = $v;
		}
		$this->data['users_data'] = $result_info;
		$this->adminRenderTemplate('admin/users/index', $this->data);
	}

	public function fetch_users()
	{
		$fetch_data = $this->user_model->make_datatables();
		$data = array();
		foreach ($fetch_data as $row) {
			$sub_array = array();
			$sub_array[] = $row->first_name;
			$sub_array[] = $row->last_name;
			$sub_array[] = $row->email;
			$sub_array[] = $row->phone;
			if($row->status==1){
				$sub_array[] = 'Active';
			} else {
				$sub_array[] = 'Inactive';
			}
			$sub_array1 = '<a href="' . base_url('admin/users/edit/' . $row->id) . '" class="btn btn-warning"  style="margin-right:5px;"><i class="fa fa-edit"></i></a><a href="javascript:void(0);" class="btn btn-danger deleteRecord" data-id="' . $row->id . '" data-controller="users" data-title="user"><i class="fa fa-trash"></i></a>';
			$sub_array[] = $sub_array1;
			$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->user_model->get_all_data(),
			"recordsFiltered" => $this->user_model->get_filtered_data(),
			"data" => $data,
		);
		echo json_encode($output);

	}

	public function create()
	{
		if(($this->input->post('firstname')!='') && ($this->input->post('lastname')!='') && ($this->input->post('phone')!='') && ($this->input->post('email')!='') && ($this->input->post('username')!='') && ($this->input->post('password')!='')){

			// true case
			$password = md5($this->input->post('password'));
			$data = array(
				'username' => $this->input->post('username'),
				'password' => $password,
				'email' => $this->input->post('email'),
				'firstname' => $this->input->post('firstname'),
				'lastname' => $this->input->post('lastname'),
				'phone' => $this->input->post('phone')
			);

			$create = $this->user_model->create($data);
			if($create == true) {
				$this->session->set_flashdata('success', $this->lang->line('lang_successfully_created_applicants'));
				redirect('students', 'refresh');
			}
			else {
				$this->session->set_flashdata('error', $this->lang->line('lang_error_occurred'));
				redirect('admin/users/create', 'refresh');
			}

		} else {
			$this->data['datas'] = '';
			$this->adminRenderTemplate('admin/users/create', $this->data);
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

					$data = array(
						'username' => $this->input->post('username'),
						'password' => $password,
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
			} else {
				// false case
				$student_data = $this->user_model->getStudentData($id);

				$this->data['student_data'] = $student_data;

				@$this->render_template('admin/users/edit', $this->data);
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

	public function check_student_email_exist()
	{
		$email = $this->input->post('email');
		if($email != ''){
			$data['student_email']=$this->user_model->check_student_email_exist($email);

			$return = '';
			if($data['student_email'] == 'Yes'){
				$return = false;
			} else {
				$return = true;
			}

			echo json_encode($return);
			exit();
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

	public function check_other_student_email_exist()
	{
		$email = $this->input->post('email');
		$id = $this->input->post('id');
		if($email != ''){
			$data['student_email']=$this->user_model->check_other_email('students',$email,$id);

			$return = '';
			if($data['student_email'] == 'Yes'){
				$return = false;
			} else {
				$return = true;
			}

			echo json_encode($return);
			exit();
		}
	}

	public function check_other_username_exist()
	{
		$username = $this->input->post('username');
		$id = $this->input->post('id');
		if($username != ''){
			$data['student_email']=$this->user_model->check_other_username('students',$username,$id);
			$return = '';
			if($data['student_email'] == 'Yes'){
				$return = false;
			} else {
				$return = true;
			}

			echo json_encode($return);
			exit();
		}
	}

	public function export()
	{

		$user_data = $this->user_model->getStudentData();

		if(count($user_data)>0){

			$delimiter = ",";
			$filename = "SARIMA-STUDENTS-LIST-" . date('Y-m-d-h-i-s') . ".csv";

			//create a file pointer
			$f = fopen('php://memory', 'w');

			//set column headers
			$fields = array('User Name', 'Name', 'Email Address', 'Phone No.');
			fputcsv($f, $fields, $delimiter);

			//output each row of the data, format line as csv and write to file pointer
			foreach ($user_data as $key => $value) {

				$username = $value['username'];

				$name = $value['firstname'].' '.$value['lastname'];

				$email = $value['email'];

				$phone = $value['phone'];

				$lineData = array($username, $name, $email, $phone);

				fputcsv($f, $lineData, $delimiter);
			}


			//move back to beginning of file
			fseek($f, 0);

			//set headers to download file rather than displayed
			header('Content-Type: text/csv');
			header('Content-Disposition: attachment; filename="' . $filename . '";');

			//output all remaining data on a file pointer
			fpassthru($f);

		} else {
			$this->session->set_flashdata('error', $this->lang->line('lang_error_occurred'));
			redirect('students', 'refresh');
		}
	}
}
