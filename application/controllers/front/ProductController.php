<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductController extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Banner_model');
        $this->load->model('Product_model');
        $this->load->model('Categories_model');
    }

    public function index(){
        $categoryId = $this->input->get('categoryId');
        $data['products'] = $this->Product_model->filter_products($categoryId);
        $content = $this->load->view('front/Products/filter', $data, TRUE);
        $response = [
            'status'   => !empty($data['products']) ? true : false,
            'html'     => $content
        ];

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function show($id){
        $data['product']                   = $this->Product_model->show($id);
        $data['product']['sizes']          = $this->Product_model->product_sizes($id);
        $data['product']['colors']         = $this->Product_model->product_colors($id);
        $data['product']['stock_status']   = $this->Product_model::$stock_status;
        $data['product']['quantity']       = $this->Product_model::$quantity;

        $response = [
            'status'   => !empty($data['product']) ? true : false,
            'html'     => $this->load->view('front/Products/quickView', $data, TRUE)
        ];

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }    
}