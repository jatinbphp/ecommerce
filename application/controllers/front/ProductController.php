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
        $this->load->model('Categories_model');
    }

    /**
     * Retrieves filtered products based on the provided category ID.
     * 
     * This method fetches products from the database using the Product_model based on the given category ID obtained from the input. 
     * It then loads a view with the filtered products data and returns the HTML content as part of a JSON response.
     * 
     * @return void
     */
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

    public function addToFaviourits(){
        $productId = $this->input->post('id');
        
        $loggedInUserData = $this->session->get_userdata();

        if(!$userId = $this->session->userdata('userId')){
            return '';
        }

            $sql = "SELECT * FROM wishlists WHERE user_id = ? AND product_id = ?";
            $query = $this->db->query($sql, [$userId, $productId]);
            $wishlist = $query->row_array();

        if ($wishlist) {
            $this->db->where('user_id', $userId);
            $this->db->where('product_id', $productId);
            $this->db->delete('wishlists');
            $type = 2;
        } else {
            $input['user_id'] = $userId;
            $input['product_id'] = $productId;
            $create = $this->db->insert('wishlists', $input);
            $type = 1;
        }

        $responseData = [
            'total' => count($this->getWishlistProductIds()),
            'type' => $type,
        ];

        // Return the data as JSON response
        $this->output->set_content_type('application/json')
            ->set_output(json_encode($responseData));
    }

    public function getWishlistProductIds(){
        if(!$userId = $this->session->userdata('userId')){
            return 0;
        }
        $sql = "SELECT * FROM wishlists WHERE user_id = ?";
        $query = $this->db->query($sql, [$userId]);
        return $query->result_array();
    }
}