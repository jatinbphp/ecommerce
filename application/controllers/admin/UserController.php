<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This class represents a user controller that extends the MY_Controller class.
 */
class UserController extends MY_Controller
{
	/**
	 * Constructor for the Users class.
	* Initializes the parent constructor.
	* Checks if the admin is logged in.
	* Sets the page title to 'Users' and the form title to 'User'.
	* Loads the user_model, countries_model, and user_address_model.
	*/
	public function __construct()
	{
		parent::__construct();
		$this->checkAdminLoggedIn();
		$this->data['page_title'] = 'Users';
		$this->data['form_title'] = 'User';
		$this->load->model('user_model');
		$this->load->model('countries_model');
		$this->load->model('user_address_model');
		$this->load->model('Countries_model');
	}

	/**
	 * Render the index page for the users in the admin panel.
	*/
	public function index()
	{
		$this->adminRenderTemplate('admin/users/index', $this->data);
	}

	/**
	 * Fetches users data and formats it for DataTables.
	*
	* Retrieves user data from the database using the user_model's make_datatables method,
	* formats the data into an array suitable for DataTables display, including status buttons,
	* edit and delete buttons, and view user details button.
	*
	* @return void
	*/
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
			$usersData[] = '<a href="' . base_url('admin/users/edit/' . $row->id) . '" class="btn btn-sm btn-info"  style="margin-right:5px;"><i class="fa fa-edit"></i></a><a href="javascript:void(0);" class="btn btn-sm btn-danger deleteRecord" style="margin-right:5px;" data-id="' . $row->id . '" data-controller="users" data-title="user"><i class="fa fa-trash"></i></a><a href="javascript:void(0)" title="View User" data-id="'. $row->id .'" class="btn btn-sm btn-warning tip  view-info" data-title="User Details" data-url="'.base_url('admin/users/show/' . $row->id).'">
            	<i class="fa fa-eye"></i></a>';

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

	/**
	 * Validates form input and creates a new user with the provided data.
	* 
	* This method sets validation rules for various form fields such as first name, last name, password, email, etc.
	* If the form validation fails, it reloads the create user page with appropriate error messages.
	* If the form validation passes, it hashes the password, prepares user data, and adds the user to the database.
	* If the user is successfully added, it uploads and updates the user image if provided, sets success message, and redirects to the edit user page.
	* If an error occurs during user creation, it sets an error message and redirects back to the create user page.
	* 
	* @return $this
	*/
	public function create()
	{
		$this->form_validation->set_rules('first_name', 'Name', 'required');
		$this->form_validation->set_rules('last_name', 'Name', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|callback_strong_password_check|matches[confirm_password]');
		$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required');	
		$this->form_validation->set_rules('mobileNo', 'Phone', 'required|numeric');
		$this->form_validation->set_rules('countryCode', '', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');

		if ($this->form_validation->run() == FALSE) {
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
			if ($path = $this->uploadFile('uploads/users', $_FILES)) {
		        $this->user_model->updateUserImage($create,$path);
			}

			$this->session->set_flashdata('success', 'User has been inserted successfully! Please add user addresses.');
			redirect('admin/users/edit/'.$create, 'refresh');
		}
		else {
			$this->session->set_flashdata('error', $this->lang->line('lang_error_occurred'));
			redirect('admin/users/create', 'refresh');
		}
	}
	
	/**
	 * Edit user details based on the provided user ID.
	*
	* @param int|null $id
	*/
	public function edit($id = null)
	{
		if($id) {
			$this->form_validation->set_rules('first_name', 'Name', 'required');
			$this->form_validation->set_rules('last_name', 'Name', 'required');
			
			$this->form_validation->set_rules('mobileNo', 'Phone', 'required|numeric');
			$this->form_validation->set_rules('countryCode', '', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

			$userId = $id;

			if ($this->form_validation->run() == FALSE) {

				$getUsrAddr = $this->user_address_model->getUserAddresses($userId); 
				$userAddrCnt = count($getUsrAddr);

				$usersData = $this->user_model->getUserData($userId);
				if(empty($usersData)){
					redirect('admin/404', 'refresh');
				}
				$this->data['userData'] = $usersData;
				$this->data['status'] = $this->user_model::$status;
				$this->data['userAddress'] = $getUsrAddr;
				$this->data['countries'] = $this->Countries_model->getCountrCodeWiseCountry();
				$this->data['addressType'] = $this->user_address_model::$addressType;
				$this->data['userAddressCnt'] = $userAddrCnt;
				$getCountryCode = $this->countries_model->getCountryData();
				$this->data['countryCodes'] = $getCountryCode;
				$this->adminRenderTemplate('admin/users/create', $this->data);
				return;
			}

			if(isset($_POST['addresses']['existing']))
			{
				$addresses = $this->input->post('addresses')['existing'];
				foreach ($addresses as $key => $address) {
					// $this->form_validation->set_rules("addresses[existing][$key][title]", 'Title', 'required');
					$this->form_validation->set_rules("addresses[existing][$key][first_name]", 'First Name', 'required');
					$this->form_validation->set_rules("addresses[existing][$key][last_name]", 'Last Name', 'required');
					$this->form_validation->set_rules("addresses[existing][$key][mobile_phone]", 'Mobile No', 'required');
					$this->form_validation->set_rules("addresses[existing][$key][address_line1]", 'Address', 'required');
					$this->form_validation->set_rules("addresses[existing][$key][pincode]", 'ZIP / Pincode', 'required');
					$this->form_validation->set_rules("addresses[existing][$key][country]", 'Country', 'required');
					$this->form_validation->set_rules("addresses[existing][$key][state]", 'State', 'required');
					$this->form_validation->set_rules("addresses[existing][$key][city]", 'City / Town', 'required');
					$this->form_validation->set_rules("addresses[existing][$key][address_type]", 'Address type', 'required');
				}

				if ($this->form_validation->run() == FALSE) {
					$error_messages = validation_errors();
					$this->session->set_flashdata('error', $error_messages);
					redirect('admin/users/edit/'.$userId, 'refresh');
				} else {
					foreach ($addresses as $id => $address) {
						$this->user_address_model->updateAddress($id, $address);
	            	}
				}
			}

			if(isset($_POST['addresses']['new']))
			{
				$newAddresses = $this->input->post('addresses')['new'];

				foreach ($newAddresses as $key => $address) {

			            // $this->form_validation->set_rules("addresses[new][$key][title]", 'Title', 'required');
			            $this->form_validation->set_rules("addresses[new][$key][first_name]", 'First Name', 'required');
			            $this->form_validation->set_rules("addresses[new][$key][last_name]", 'Last Name', 'required');
			            $this->form_validation->set_rules("addresses[new][$key][mobile_phone]", 'Mobile No', 'required');
			            $this->form_validation->set_rules("addresses[new][$key][address_line1]", 'Address', 'required');
			            $this->form_validation->set_rules("addresses[new][$key][pincode]", 'ZIP / Pincode', 'required');
			            $this->form_validation->set_rules("addresses[new][$key][country]", 'Country', 'required');
			            $this->form_validation->set_rules("addresses[new][$key][state]", 'State', 'required');
			            $this->form_validation->set_rules("addresses[new][$key][city]", 'City / Town', 'required');
			            $this->form_validation->set_rules("addresses[new][$key][address_type]", 'Address type', 'required');
	    		}

	    		if ($this->form_validation->run() == FALSE) {
	    			$error_messages = validation_errors();
					$this->session->set_flashdata('error', $error_messages);
					redirect('admin/users/edit/'.$userId, 'refresh');
				}
				else
				{
					 foreach ($newAddresses as $address) {
					 	$address['user_id'] = $userId;
		                $this->user_address_model->createByUser($address);
	            	}
				}
			}


			//process images
			if ($path = $this->uploadFile('uploads/users', $_FILES)) {
				$getUsrImg = $this->user_model->getUserData($id);
				if(isset($getUsrImg['image']))
				{
					if (file_exists($getUsrImg['image'])) {
						unlink($getUsrImg['image']);
					}
				}
		        $this->user_model->updateUserImage($userId,$path);
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

				if($this->user_model->isEmailExists($this->input->post('email')))
				{
					unset($data['email']);
				}

				$update = $this->user_model->edit($data, $userId);
				if($update == true) {
					$this->session->set_flashdata('success','User has been updated successfully!');
					redirect(base_url('admin/users'));
				}
				else {
					$this->session->set_flashdata('error', 'Something went wrong');
					redirect('admin/users/edit/'.$userId, 'refresh');
				}
			}
			else {

				$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|callback_strong_password_check|matches[confirm_password]');
				$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required');	

				if ($this->form_validation->run() == FALSE) {
					$error_messages = validation_errors();
					$this->session->set_flashdata('error', $error_messages);
					redirect('admin/users/edit/'.$userId, 'refresh');
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

				if($this->user_model->isEmailExists($this->input->post('email')))
				{
					unset($data['email']);
				}

				$update = $this->user_model->edit($data, $userId);
				if($update == true) {
					$this->session->set_flashdata('success','User has been updated successfully!');
					redirect(base_url('admin/users'));
				}
				else {
					$this->session->set_flashdata('error', 'Error Occured');
					redirect('admin/users/edit/'.$userId, 'refresh');
				}
			}
		}
	}

	/**
	 * Delete a user and their associated data based on the provided ID.
	*
	* @param int $id The ID of the user to be deleted.
	* @return bool Returns true if the user and associated data were successfully deleted, false otherwise.
	*/
	public function delete($id)
	{
		if($id) {
			$users = $this->user_model->getUserData($id);

			if(isset($users['image'])){
				if (file_exists($users['image'])) {
					unlink($users['image']);
				}
			}

			$delete = $this->user_model->delete($id);
			if($delete == true) {
				$this->user_address_model->deleteUserAddress($id);
			}
			echo true;
		}
		echo false;
	}

	/**
	 * Check if the username provided in the input exists in the database.
	* 
	* This method retrieves the username from the input, checks its existence in the database using the user_model,
	* and returns a JSON response indicating whether the username exists or not.
	* 
	* @return void
	*/
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

	/**
	 * Deletes the address based on the address_id received from the input.
	* It calls the deleteAddress method of the user_address_model to delete the address.
	* Returns a JSON response indicating the success or failure of the deletion operation.
	*/
	public function deleteAddress() {
        $addressId = $this->input->post('address_id');

        // Delete address record
        $success = $this->user_address_model->deleteAddress($addressId);

        // Prepare response
        $response = array();
        if ($success) {
            $response['success'] = true;
            $response['message'] = 'Address deleted successfully.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Failed to delete address.';
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * Checks if the given password meets the criteria for a strong password.
     *
     * The password must contain at least one lowercase letter, one uppercase letter, and one digit,
     * and have a minimum length of 6 characters.
     *
     * @param string $password The password to be checked
     * @return bool Returns TRUE if the password is strong, FALSE otherwise
     */
   	public function strong_password_check($password) {
	    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/', $password)) {
	        $this->form_validation->set_message('password_check', 'Your password must contain at least one lowercase letter, one uppercase letter, and one digit');
	        return FALSE;
	    } else {
	        return TRUE;
	    }
    }

    /**
     * Display the user data for the specified user ID.
     *
     * @param int $id The ID of the user
     * @return void
     */
    public function show($id){
        $user = $this->user_model->getUserData($id);
       	$data['user'] = $user;
        $html = $this->load->view('admin/users/view', $data, true);
        echo $html;
    }
}
