<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class ProductController
 *
 * This class extends the MY_Controller class and serves as the controller for managing products.
 */
class ProductController extends MY_Controller {

    /**
     * Constructor for the class. Initializes Banner_model, Product_model, and Categories_model.
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Banner_model');
        $this->load->model('Product_model');
        $this->load->model('ProductOptions_model');
        $this->load->model('Categories_model');
        $this->load->model('Wishlist_model');
        $this->load->model('ProductOptions_model');
        $this->load->model('Reviews_model');
        $this->load->model('User_model');
    }

    /**
     * Retrieves filtered products based on the provided category ID.
     * 
     * This method fetches products from the database using the Product_model based on the given category ID obtained from the input. 
     * It then loads a view with the filtered products data and returns the HTML content as part of a JSON response.
     * 
     * @return void
     */
    public function index(){
        $filters                    = $this->input->get('filter');
        $keyword = $this->input->get('keyword');
        if (!empty($keyword)) {
            $data['products']       = $this->Product_model->search_products($keyword);
        }
        else{
            $data['products']       = $this->Product_model->filter_products($filters);
        }
        $data['wishlistProductId']  = $this->Wishlist_model->getWishlistProductIds();
        $data['type']               = $this->Product_model::$type;
        $data['productWiseReviews'] = $this->Reviews_model->getProductWiseReviewData();
        $data['viewType']           = $this->input->get('viewType', '');
        $content                    = $this->load->view('front/Products/filter', $data, TRUE);
        $response = [
            'status'   => !empty($data['products']) ? true : false,
            'html'     => $content
        ];

        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * Display the product details for the given ID.
     *
     * Retrieves product data based on the provided ID, checks if the product exists,
     * generates HTML view for the product details, and outputs the response in JSON format.
     *
     * @param int $id The ID of the product to display
     * @return void
     */
    public function show($id) {
        $data = $this->Product_model->product_data($id);
        $response = [
            'status' => !empty($data['product']) ? true : false,
            'html'   => $this->load->view('front/Products/view', $data, TRUE)
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * Display the details of a product based on the provided ID.
     *
     * @param int $id The ID of the product
     * @return void
     */
    public function details($slug) {
        $productId = $this->Product_model->getProductIdBasedOnSlug($slug);
        $data = $this->Product_model->product_data($productId);
        $this->frontRenderTemplate('front/Products/details', $data);
    }

    /**
     * Retrieve unique option names from the ProductOptions_model and return them as a JSON response.
     *
     * @return void
     */
    public function options(){
        $option_names = $this->ProductOptions_model->getUniqueOptionNames();
        $response = [
            'status' => !empty($option_names) ? true : false,
            'data'   => $option_names
        ];

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
}