<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This class represents a controller for managing subscriptions.
 * It extends the MY_Controller class, which is likely a custom base controller class.
 */
class SubscriptionController extends MY_Controller
{
    public function __construct(){
		parent::__construct();
		$this->load->model('Subscription_plan_users_model');
		$this->load->model('SubscriptionPlan_model');
	}

    public function getPlanData() {
        $userEmail = $this->input->post('email');
        $allPlans = $this->SubscriptionPlan_model->getDetails();
        $addedPlans = $this->Subscription_plan_users_model->getDetailsByEmail($userEmail) ?? [];
        $addedPlans = array_column($addedPlans, 'subscription_id');
        echo $this->load->view('front/Subscription/view', ['allPlans' => $allPlans, 'userEmail' => $userEmail, 'addedPlans' => $addedPlans], true);
    }

    public function updatePlanData(){
        $action = $this->input->post('action');
        $planId = $this->input->post('planId');
        $email = $this->input->post('email');
        $message = '';

        $responce['status'] = 0;

        if(!$action || !$planId || !$email){
            $responce['messge'] = 'Something went wrong!';
            return $this->output->set_content_type('application/json')
            ->set_output(json_encode($responce));
        }
        
        $data['subscription_id'] = $planId;
        $data['email'] = $email;
        if($action == 'remove'){
            $this->Subscription_plan_users_model->deleteByEmailAndSubscriptionId($data);
            $message = 'Your email removed successfully from subscription.';
        } else {
            $this->Subscription_plan_users_model->create($data);
            $message = 'Your email added successfully for subscription.';
        }
        $responce['message'] = $message;
        $responce['status'] = 1;
        return $this->output->set_content_type('application/json')
            ->set_output(json_encode($responce));
    }
}