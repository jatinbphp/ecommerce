<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class HomeController
 *
 * This class extends the MY_Controller class and serves as the controller for the home page.
 */
class HomeController extends MY_Controller {

 /**
  * Constructor for the class.
  * Loads the Banner_model, Product_model, and Categories_model.
  */
	public function __construct() {
        parent::__construct();
        $this->load->model('Banner_model');
        $this->load->model('Product_model');
        $this->load->model('Categories_model');
        $this->load->model('Reviews_model');
        $this->load->model('Settings_model');
    }

    /**
     * Retrieves data for the home page including banner data, latest products, and categories with many products.
     * Renders the front home page template with the retrieved data.
     */
    public function index() {
        $data['banner_data']           = $this->Banner_model->getActiveBammerData();
        $data['latest_products']       = $this->Product_model->getLatestProducts();
        $data['categories']            = $this->Categories_model->getCategoriesWithManyProducts();
        $firstCategory = current($data['categories']);
        $filters['categoryId']         = isset($firstCategory['id']) ? $firstCategory['id'] : 0;
        $data['categorized_products']  = $this->Product_model->filter_products($filters);
        $data['type']                  = $this->Product_model::$type;
        $data['productWiseReviews']    = $this->Reviews_model->getProductWiseReviewData();
        $settingsData = $this->Settings_model->getSettingsById(1);
        $data['allow_banner_value']    = $settingsData['is_allow_auto_move_banners'] ?? 0;
        $this->frontRenderTemplate('front/Home/homePage', $data);
    }

    /**
     * Display the 'About Us' page.
     */
    public function aboutUs() {
        $sql = "SELECT * FROM content_management WHERE id = ?";
        $query = $this->db->query($sql, [4]);
        $data = $query->row_array();
        $this->frontRenderTemplate('front/About/aboutUs', ['aboutUsData' => $data]);
    }

    /**
     * Render the shop page template.
     */
    public function shopPage() {
        $this->frontRenderTemplate('front/Shop/shop');
    }
    
    /**
     * Retrieve the terms and conditions data from the database and render the terms and conditions page.
     */
    public function termaConditions() {
        $sql = "SELECT * FROM content_management WHERE id = ?";
        $query = $this->db->query($sql, [2]);
        $data = $query->row_array();
        $this->frontRenderTemplate('front/TermsConditions/termaConditionsPage',['terms_data' => $data]);
    }

    /**
     * Retrieves the privacy policy content from the database and renders the privacy policy page template.
     *
     * This method fetches the privacy policy content from the 'content_management' table in the database
     * based on the ID 1. It then passes the retrieved data to the frontRenderTemplate method to render
     * the 'front/PrivecyPolicy/privecyPolicyPage' template with the privacy data.
     */
    public function privecyPolicy() {
        $sql = "SELECT * FROM content_management WHERE id = ?";
        $query = $this->db->query($sql, [1]);
        $data = $query->row_array();
        $this->frontRenderTemplate('front/PrivecyPolicy/privecyPolicyPage',['privecy_data' => $data]);
    }

    /**
     * Render the profile information template for the user's account.
     */
    public function profile_info() {
        $this->frontRenderTemplate('front/myAccount/profile-info');
    }

    /**
     * Render the profile address template for the user.
     */
    public function profile_address() {
        $this->frontRenderTemplate('front/myAccount/address/index');
    }

    /**
     * retrive and store cart data in session.
     */
    public function saveCartData() {
        $data = $this->input->get('cartData');
        if ($data) {
            $this->session->set_userdata('cartData', $data);
        } else {
            $this->session->set_userdata('cartData', '');
        }

        // Return response with new CSRF token
        $response = [
        ];

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    /**
     * Generate and return a CSRF token.
     *
     * This method retrieves the current CSRF (Cross-Site Request Forgery) token
     * from the security library and returns it in a JSON response. The CSRF token
     * is used to protect forms and other sensitive operations from CSRF attacks.
     * 
     * The response includes the CSRF token in the following format:
     * {
     *     "csrf_token_value": "your_csrf_token_here"
     * }
     *
     * @return CI_Output JSON response containing the CSRF token.
     */

    public function getTocken(){
        $response = [
            'csrf_token_value' => $this->security->get_csrf_hash()
        ];

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    /**
     * Load and render the 404 error page.
     *
     * This method is responsible for loading and rendering the 404 error page 
     * template. It uses the front-end rendering template function to display 
     * the 'error-404' view when a requested page is not found.
     * 
     * This method does not return any value but directly renders the 404 error 
     * page to inform the user that the requested resource could not be found.
     *
     * @return void
     */

    public function load404(){
        $this->frontRenderTemplate('error-404');
    }
    
    /**
     * Retrieve and return the logged-in user's ID.
     *
     * This method fetches the user ID of the currently logged-in user from the session data.
     * It then returns the user ID in a JSON response. The user ID is stored in the session 
     * under the key 'userId'.
     * 
     * The response includes the user ID in the following format:
     * {
     *     "user_id": "logged_in_user_id_here"
     * }
     *
     * @return CI_Output JSON response containing the user ID.
     */

    public function getLoggedInUserId(){
        $response = [
            'user_id' => $this->session->userdata('userId'),
        ];

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}