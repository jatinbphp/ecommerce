<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReviewsController extends MY_Controller {

    /**
     * Constructor for the ReviewsController class.
     * Initializes the parent constructor and loads the Reviews_model.
     */
    public function __construct(){
		parent::__construct();
		$this->load->model('Reviews_model');
	}

    /**
     * Adds a review for a product.
     *
     * Retrieves input data from the POST request, sets the user ID based on the session data.
     * Creates a new review using the Reviews_model and retrieves review details based on the product ID.
     * Updates the HTML content for the reviews section.
     * Sets success and message variables based on the review creation status.
     * Returns a JSON response containing success status, message, and updated review HTML.
     *
     * @return \CI_Output
     */
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