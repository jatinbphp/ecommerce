<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductController extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Banner_model');
        $this->load->model('Product_model');
        $this->load->model('Categories_model');
    }

    public function getProducts(){
        $categoryId = $this->input->get('categoryId');
        $data['products'] = $this->Product_model->getFilteredProducts($categoryId);
        $view_content = $this->load->view('front/Products/filteredProducts', $data, TRUE);
        $response = [
            'success' => true,
            'html' => $view_content
        ];

        $this->output->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    
}