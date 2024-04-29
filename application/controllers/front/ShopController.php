<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ShopController extends MY_Controller {

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

    public function index(){
        $data['categories'] = $this->product_categories();
        $data['options'] = $this->product_options();
        $this->frontRenderTemplate('front/Shop/shop', $data);
    }

    private function product_categories(){
        $data = $this->Categories_model->get_categories_recursive();
        return $data;
    }

    private function product_options(){
        $option_names = $this->ProductOptions_model->getUniqueOptionNames();

        if(empty($option_names)){
            return [];
        }

        $option_names_array = [];
        foreach($option_names as $name){
            $option_names_array[$name] = $this->ProductOptions_model->getOptionsByName($name);
        }

        $option_values = [];
        if(!empty($option_names_array)){
            foreach($option_names as $name){
                if(isset($option_names_array[$name])){
                    $option_ids = $option_names_array[$name];
                    $option_values[$name] = $this->ProductOptionValues_model->filterProductOptions('', $option_ids, '');
                }
            }
        }

        return $option_values;
    }
}