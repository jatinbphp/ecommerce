<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SubscriptionPlanController extends MY_Controller
{
	protected $_data = [];
	public function __construct(){
		parent::__construct();
		$this->checkAdminLoggedIn();
		$this->data['page_title'] = 'Subscription Plans';
		$this->data['form_title'] = 'Subscription Plan';
		$this->load->model('SubscriptionPlan_model');
	}

	public function index(){
		$this->adminRenderTemplate('admin/SubscriptionPlan/index', $this->data);
	}

	public function fetchSubscriptionPlan(){
		$data    = [];
		$allData = $this->SubscriptionPlan_model->make_datatables();

		foreach ($allData as $row) {
			$subscriptionPlanData = [];
			$subscriptionPlanData[] = "#".$row->id;
			$subscriptionPlanData[] = $row->name;
			$subscriptionPlanData[] = $this->SubscriptionPlan_model::$duration[$row->duration] ?? null;
			$subscriptionPlanData[] = $this->getStatusButton($row->id, $row->status, 'subscription_plans');
			$subscriptionPlanData[] = $row->created_at;
			$subscriptionPlanData[] = '<a href="' . base_url('admin/subscription-plan/edit/' . $row->id) . '" class="btn btn-sm btn-info"  style="margin-right:5px;"><i class="fa fa-edit"></i></a><a href="javascript:void(0);" class="btn btn-sm btn-danger deleteRecord" style="margin-right:5px;" data-id="' . $row->id . '" data-controller="subscription-plan" data-title="subscription plan"><i class="fa fa-trash"></i></a>';
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

	public function create(){
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('duration', 'Duration', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
        	$this->data['status'] = $this->SubscriptionPlan_model::$status;
        	$this->data['duration'] = $this->SubscriptionPlan_model::$duration;
        	$this->adminRenderTemplate('admin/SubscriptionPlan/create', $this->data);
        	return $this;
        }

		$data = [
			'name' 			=> $this->input->post('name'),
			'duration' 		=> $this->input->post('duration'),
			'description' 	=> !empty(strip_tags($this->input->post('description'))) ? $this->input->post('description') : null,
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

	public function edit($id = null){
		if($id) {
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('duration', 'Duration', 'required');
			$this->form_validation->set_rules('description', 'Description', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');

			if($this->form_validation->run()){
				$data = [
					'name' 			=> $this->input->post('name'),
					'duration' 		=> $this->input->post('duration'),
					'description' 	=> !empty(strip_tags($this->input->post('description'))) ? $this->input->post('description') : null,
					'status' 		=> $this->input->post('status'),
					'created_at' 	=> date("Y-m-d H:i:s"),
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
				$this->data['subscription_plan_data'] = $subscriptionPlanData;
				$this->data['status'] = $this->SubscriptionPlan_model::$status;
				$this->data['duration'] = $this->SubscriptionPlan_model::$duration;
				$this->adminRenderTemplate('admin/SubscriptionPlan/edit', $this->data);
			}
		}
	}

	public function delete($id){
		if($id) {			
			$delete = $this->SubscriptionPlan_model->delete($id);
			if($delete == true){
				echo true;
			}
		}
	}
}