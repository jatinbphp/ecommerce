<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ShopController class extends MY_Controller.
 * This class is responsible for handling requests related to the shop in the application.
 */
class ShopController extends MY_Controller {

    /**
     * Constructor method for initializing the class and loading necessary models.
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Banner_model');
        $this->load->model('Product_model');
        $this->load->model('ProductOptions_model');
        $this->load->model('Categories_model');
        $this->load->model('Wishlist_model');
        $this->load->model('Categories_model');
        $this->load->model('ProductOptions_model');
        $this->load->model('ProductOptionValues_model');
    }

    /**
     * Retrieves product categories and options data, then renders the front shop template with the provided data.
     *
     * @return void
     */
    public function index(){
        $data['categories'] = $this->product_categories();
        $data['options']    = $this->product_options();
        $this->frontRenderTemplate('front/Shop/shop', $data);
    }

    /**
     * Retrieve all product categories recursively from the Categories_model.
     *
     * @return array
     */
    private function product_categories(){
        $data = $this->Categories_model->get_categories_recursive();
        return $data;
    }

    /**
     * Retrieve product options and their values.
     *
     * This method retrieves unique option names from the ProductOptions_model,
     * then fetches corresponding options for each name. It then filters the product options
     * using the ProductOptionValues_model to get the option values.
     *
     * @return array An associative array containing option names as keys and their values as arrays
     */
    private function product_options(){
        $option_names = $this->ProductOptions_model->getUniqueOptionNames();

        if(empty($option_names)){
            return [];
        }

        $option_names_array = [];
        foreach($option_names as $name){
            $option_names_array[$name] = $this->ProductOptions_model->getOptionsByName($name);
        }

        if(empty($option_names_array)){
            return [];
        }
       
        $option_values = [];
        if(!empty($option_names_array)){
            foreach($option_names_array as $name => $data){
                $option_values[$name] = $this->ProductOptionValues_model->filterProductOptions($data);
            }
        }
       
        return $option_values;
    }

    /**
     * Filter products by category ID and render the shop template with the filtered data.
     *
     * @param int $id The ID of the category to filter by.
     * @return void
     */
    public function categoryFilter($id){
        $data['categories'] = $this->product_categories();
        $data['options']    = $this->product_options();
        $data['categoryId'] = $id;
        $this->frontRenderTemplate('front/Shop/shop', $data);
    }
}