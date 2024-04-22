<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WishlistController extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->checkUserLoggedIn();
        $this->load->model('Wishlist_model');
        $this->load->model('Product_model');
    }

    public function index() {
        $data['title']= "My Wishlist";
        
        if ($this->isLoggedIn()) {
            $userData = $this->session->userdata('user_data');
            if (is_array($userData)) {
                $userDataArray = $userData;
            } else {
                $userDataArray = get_object_vars($userData);
            }
        }

        $user_id        = $userDataArray['id'];
        $wishlist_items = $this->Wishlist_model->getWishlistItems($user_id);
        $product_ids    = array_column($wishlist_items, 'product_id');
       
        $data['wishlists'] = $this->Product_model->getProductsByIds($product_ids);
   
        $this->frontRenderTemplate('front/myAccount/wishlist/index', $data);
    }

    public function removeItems($id)
    {
        $deleted = $this->Wishlist_model->deleteFromWishlist($id);

        if ($deleted) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    
}