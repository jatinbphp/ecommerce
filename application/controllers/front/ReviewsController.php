<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReviewsController extends MY_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('Reviews_model');
	}

    public function addReview(){
        $input = $this->input->post();
        $input['user_id'] = (($this->session->userdata('userId') ?? 0));

        if($this->Reviews_model->create($input)){
            $reviewData = $this->Reviews_model->getDetailsBasedOnProductId($this->input->post('product_id'));
            $data['html'] = $this->load->view('front/Products/DetailsTab/ReviewsInfo', ['reviews' => $reviewData], true);
            $success = 1;
            $message = "Your review has been submitted successfully!";
        } else {
            $success = 0;
            $message = "Something Went Wrong.";
        }
        $data['success'] = $success;
        $data['message'] = $message;

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

}