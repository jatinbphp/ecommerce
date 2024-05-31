<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This class represents a controller for managing subscription plans.
 * It extends the MY_Controller class, which is likely a custom base controller class.
 */
class SubscriptionPlanController extends MY_Controller
{
	protected $_data = [];
	/**
	 * Constructor for the SubscriptionPlansController class.
	* Initializes the parent constructor and checks if the admin is logged in.
	* Sets the page title and form title for the view.
	* Loads the SubscriptionPlan_model.
	*/
	public function __construct(){
		parent::__construct();
		$this->checkAdminLoggedIn();
		$this->data['page_title'] = 'Subscription';
		$this->data['form_title'] = 'Subscription';
		$this->load->model('SubscriptionPlan_model');
		$this->load->model('Subscription_plan_users_model');
	}

	/**
	 * Render the index page for the Subscription Plan in the admin panel.
	*/
	public function index(){
		$this->adminRenderTemplate('admin/SubscriptionPlan/index', $this->data);
	}

	/**
	 * Fetches subscription plan data for display in a DataTable.
	* Retrieves subscription plan data from the SubscriptionPlan_model and formats it for display.
	* Includes subscription plan ID, name, duration, status button, creation date, and edit/delete buttons.
	* Returns JSON-encoded output for DataTable rendering.
	*/
	public function fetchSubscriptionPlan(){
		$data    = [];
		$allData = $this->SubscriptionPlan_model->make_datatables();

		foreach ($allData as $row) {
			$subscriptionPlanData = [];
			$subscriptionPlanData[] = "#".$row->id;
			$subscriptionPlanData[] = $row->name;
			$subscriptionPlanData[] = $this->getStatusButton($row->id, $row->status, 'subscription_plans');
			$subscriptionPlanData[] = $row->created_at;
			$subscriptionPlanData[] = '<a href="' . base_url('admin/subscription-plan/edit/' . $row->id) . '" class="btn btn-sm btn-info"  style="margin-right:5px;"><i class="fa fa-edit"></i></a>
										<a href="javascript:void(0);" class="btn btn-sm btn-danger deleteRecord" style="margin-right:5px;" data-id="' . $row->id . '" data-controller="subscription-plan" data-title="subscription plan"><i class="fa fa-trash"></i></a>
										<a href="javascript:void(0)" title="View Subscription" data-id="'. $row->id .'" class="btn btn-sm btn-warning tip view-info" data-title="Subscription Details" style="margin-right:5px;" data-url="'.base_url('admin/subscription-plan/show/' . $row->id).'"><i class="fa fa-eye"></i></a>
										<a href="' . base_url('admin/subscription-plan/send-mail-template/' . $row->id) . '" class="btn btn-sm btn-success" data-title="Send Mail" style="margin-right:5px;"><i class="fa fa-envelope"></i></a>';
			$data[] = $subscriptionPlanData;
		}

		$output = [
			"draw"            => intval($_POST["draw"]),
			"recordsTotal"    => $this->SubscriptionPlan_model->get_all_data(),
			"recordsFiltered" => $this->SubscriptionPlan_model->get_filtered_data(),
			"data"            => $data,
		];

		echo json_encode($output);
	}

	/**
	 * Create a new subscription plan based on the form input data.
	* Validates the form input data for 'name', 'duration', 'description', and 'status'.
	* If validation fails, it renders the create template with the necessary data and returns the instance.
	* If validation passes, it creates a new subscription plan with the provided data and redirects accordingly.
	*
	*/
	public function create(){
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
        	$this->data['status'] = $this->SubscriptionPlan_model::$status;
        	$this->adminRenderTemplate('admin/SubscriptionPlan/create', $this->data);
        	return $this;
        }

		$data = [
			'name' 			=> $this->input->post('name'),
			'status' 		=> $this->input->post('status'),
			'created_at' 	=> date("Y-m-d H:i:s"),
		];

		$create = $this->SubscriptionPlan_model->create($data);

		if($create == true) {
			$this->session->set_flashdata('success', 'Subscription plan has been inserted successfully!.');
			redirect('admin/subscription-plan', 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Error occurred!!');
			redirect('admin/subscription-plan/create', 'refresh');
		}
	}

	/**
	 * Edit a subscription plan by updating its details in the database.
	*
	* @param int|null $id The ID of the subscription plan to edit.
	* @return void
	*/
	public function edit($id = null){
		if($id) {
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');

			if($this->form_validation->run()){
				$data = [
					'name' 			=> $this->input->post('name'),
					'status' 		=> $this->input->post('status'),
				];

				$update = $this->SubscriptionPlan_model->edit($data, $id);

				if($update == true) {
					$this->session->set_flashdata('success', 'Subscription plan has been updated successfully!.');
					redirect('admin/subscription-plan', 'refresh');
				} else {
					$this->session->set_flashdata('error', 'Error occurred!!');
					redirect('admin/subscription-plan/edit/'.$id, 'refresh');
				}
			} else {
				$subscriptionPlanData = $this->SubscriptionPlan_model->getDetails($id);
				if(empty($subscriptionPlanData)){
					redirect('404_override');
				}
				$this->data['subscription_plan_data'] = $subscriptionPlanData;
				$this->data['status'] = $this->SubscriptionPlan_model::$status;
				$this->adminRenderTemplate('admin/SubscriptionPlan/edit', $this->data);
			}
		}
	}

	/**
	 * Delete a subscription plan by its ID.
	*
	* This method deletes a subscription plan from the database based on the provided ID.
	*
	* @param int $id The ID of the subscription plan to delete.
	* @return void
	*/
	public function delete($id){
		if($id) {			
			$delete = $this->SubscriptionPlan_model->delete($id);
			if($delete == true){
				echo true;
			}
		}
	}

	/**
	 * Display the subscription details for the given ID.
	*
	* This method retrieves subscription details,
	* based on the provided subscription ID. It then loads the view 'admin/Subscription/view'
	* with the collected data and returns the HTML content.
	*
	* @param int $id The ID of the subscription to display
	* @return void
	*/
	public function show($id) {
		$data['subscriptionData'] = $this->SubscriptionPlan_model->getDetails($id);
		$subscriptionUsersEmail = $this->Subscription_plan_users_model->getDetailsBySubscriptionId($id);
		$subscriptionUsersEmail = array_column($subscriptionUsersEmail, 'email');
		$data['subscriptionUsersEmail'] = $subscriptionUsersEmail;
        $html = $this->load->view('admin/SubscriptionPlan/view', $data, true);
        echo $html;
	}

	public function sendMailTemplate($id) {
		$this->data['form_title'] = 'Subscription Mail Template';
		$this->data['subsctiptionId'] = $id;
		$this->adminRenderTemplate('admin/SubscriptionPlan/subscriptionData', $this->data);
	}

	/**
	 * Sends a subscription mail to users based on the provided subscription ID.
	*
	* @param int $id The ID of the subscription plan
	* @return void
	*/
	public function sendMail($id) {
		if(!$id){
			$this->session->set_flashdata('error', 'something went wrong.');
			return redirect('admin/subscription-plan');
		}
		$subscriptionUsersEmail = $this->Subscription_plan_users_model->getDetailsBySubscriptionId($id);
		$subscriptionUsersEmail = array_column($subscriptionUsersEmail, 'email');
		$emails = implode(',', $subscriptionUsersEmail);
		$subject = $this->input->post('subject');
		$content = $this->input->post('content');
		if(empty($emails) || empty($subject) || empty($content)){
			$this->session->set_flashdata('error', 'something went wrong.');
			return redirect('admin/subscription-plan');
		}
		$subject = $this->input->post('subject');
		$content = $this->input->post('content');
		
		$message = $this->load->view('admin/SubscriptionPlan/subscriptionTemplate', ['content' => $content], true);

		$this->load->library('email');
		$this->email->from('noreply@gorentonline.com', $subject);
		$this->email->to($emails);
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->send();

		$this->session->set_flashdata('success', 'Subscription mail has been sent successfully!.');
		return redirect('admin/subscription-plan');
	}
}