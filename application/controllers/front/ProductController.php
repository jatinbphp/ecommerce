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
        $input                      = $this->input->get(NULL, TRUE);
        $decoded_input              = !empty($input) ? json_decode(json_encode($input), true) : [];
        $filtered_input             = !empty($decoded_input) ? array_values(array_filter($decoded_input)) : [];
        $products_options_value_ids = !empty($filtered_input) ? array_merge(...array_values($filtered_input)) : [];
        $categoryId                 = $this->input->get('categoryId');
        $data['products']           = $this->Product_model->filter_products($categoryId, $products_options_value_ids);
        $data['wishlistProductId']  = $this->Wishlist_model->getWishlistProductIds();
        $content                    = $this->load->view('front/Products/filter', $data, TRUE);
        $response = [
            'status'   => !empty($data['products']) ? true : false,
            'html'     => $content
        ];

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function show($id) {
        $data = $this->product_data($id);
        $response = [
            'status' => !empty($data['product']) ? true : false,
            'html'   => $this->load->view('front/Products/view', $data, TRUE)
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function details($id) {
        $data = $this->product_data($id);
        $this->frontRenderTemplate('front/Products/details', $data);
    }

    
    private function product_data($id) {
        $this->load->model('Wishlist_model');
        $data['product'] = $this->Product_model->show($id);
        $data['wishlistProductId'] = $this->Wishlist_model->getWishlistProductIds();
        if (!empty($data['product'])) {
            $data['product']['stock_status']    = $this->Product_model::$stock_status;
            $data['product']['quantity']        = $this->Product_model::$quantity;
            $data['product']['options']         = $this->ProductOptions_model->getOptionsWithValues($id);
        }

        return $data;
    }

    public function options(){
        $option_names = $this->ProductOptions_model->getUniqueOptionNames();
        $response = [
            'status' => !empty($option_names) ? true : false,
            'data'   => $option_names
        ];

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
}