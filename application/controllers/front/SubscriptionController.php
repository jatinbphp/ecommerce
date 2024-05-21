<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This class represents a controller for managing subscriptions.
 * It extends the MY_Controller class, which is likely a custom base controller class.
 */
class SubscriptionController extends MY_Controller
{
    /**
     * Constructor for the class.
     * Initializes the parent constructor.
     * Loads the 'Subscription_plan_users_model' and 'SubscriptionPlan_model' models.
     */
    public function __construct(){
		parent::__construct();
		$this->load->model('Subscription_plan_users_model');
		$this->load->model('SubscriptionPlan_model');
	}

    /**
     * Retrieves plan data for a user.
     *
     * This method fetches the user's email from the input, retrieves all subscription plans,
     * fetches the plans added by the user using the email, and then loads a view with the
     * retrieved data.
     *
     * @return void
     */
    public function getPlanData() {
        $userEmail = $this->input->post('email');
        $allPlans = $this->SubscriptionPlan_model->getDetails();
        $addedPlans = $this->Subscription_plan_users_model->getDetailsByEmail($userEmail) ?? [];
        $addedPlans = array_column($addedPlans, 'subscription_id');
        echo $this->load->view('front/Subscription/view', ['allPlans' => $allPlans, 'userEmail' => $userEmail, 'addedPlans' => $addedPlans], true);
    }

    /**
     * Updates the plan data based on the input received.
     *
     * This method retrieves the action, planId, and email from the input data. It then validates the input and performs
     * the necessary action based on the action type. If the action is 'remove', it deletes the email from the subscription
     * plan. If the action is not 'remove', it adds the email to the subscription plan. Finally, it returns a JSON response
     * with the status and message indicating the success or failure of the operation.
     *
     * @return mixed
     */
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