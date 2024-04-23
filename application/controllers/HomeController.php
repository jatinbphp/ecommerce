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
        $this->load->model('Cart_model');
        $this->load->model('Wishlist_model');
    }

    /**
     * Retrieves data for the home page including banner data, latest products, and categories with many products.
     * Renders the front home page template with the retrieved data.
     */
    public function index() {
        $data['banner_data']     = $this->Banner_model->getActiveBammerData();
        $data['latest_products'] = $this->Product_model->getLatestProducts();
        $data['wishlistProductId'] = $this->Wishlist_model->getWishlistProductIds();
        $data['categories']      = $this->Categories_model->getCategoriesWithManyProducts();
        $data['usrCartCounter'] = $this->Cart_model->getUserCartCounter();
        $this->frontRenderTemplate('front/Home/homePage', $data);
    }

    /**
     * Display the 'About Us' page.
     */
    public function aboutUs() {
        $this->frontRenderTemplate('front/About/aboutUs');
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
        $sql = "SELECT * FROM content_management WHERE id = 2";
        $query = $this->db->query($sql);
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
        $sql = "SELECT * FROM content_management WHERE id = 1";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        $this->frontRenderTemplate('front/PrivecyPolicy/privecyPolicyPage',['privecy_data' => $data]);
    }

    public function profile_info() {
        $this->frontRenderTemplate('front/myAccount/profile-info');
    }

    public function profile_address() {
        $this->frontRenderTemplate('front/myAccount/address/index');
    }

}