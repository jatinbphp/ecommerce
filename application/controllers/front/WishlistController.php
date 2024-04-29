<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * WishlistController class extends MY_Controller.
 * This controller handles operations related to wishlists.
 */
class WishlistController extends MY_Controller {

    /**
     * Constructor for the class.
    * It initializes the parent class and loads the Wishlist_model and Product_model.
    */
	public function __construct() {
        parent::__construct();
        $this->load->model('Wishlist_model');
        $this->load->model('Product_model');
    }

    /**
     * Display the user's wishlist.
     * 
     * This method first checks if the user is logged in. It then retrieves the user's wishlist items
     * from the database using the Wishlist_model. It extracts the product IDs from the wishlist items
     * and fetches the corresponding products using the Product_model. Finally, it renders the wishlist
     * view template with the wishlist data.
     */
    public function index() {
        $this->checkUserLoggedIn();
        $data['title']= "My Wishlist";
        $userData = $this->session->userdata();
        $user_id        = $this->session->userdata('userId');
        $wishlist_items = $this->Wishlist_model->getWishlistItems($user_id);
        $product_ids    = array_column($wishlist_items, 'product_id');
       
        $data['wishlists'] = $this->Product_model->getProductsByIds($product_ids);
        $this->frontRenderTemplate('front/myAccount/wishlist/index', $data);
    }

    /**
     * Remove an item from the wishlist based on the provided ID.
     *
     * @param int $id The ID of the item to be removed from the wishlist.
     * @return void
     */
    public function removeItems($id)
    {
        $deleted = $this->Wishlist_model->deleteFromWishlist($id);
        header('Content-Type: application/json');
        if ($deleted) {
            $wishlistItems = $this->Wishlist_model->getWishlistItems($this->session->userdata('userId'));
            echo json_encode(['success' => true, 'totalCount' => count($wishlistItems)]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    /**
     * Retrieves the wishlist data for the logged-in user.
     * It fetches the wishlist items for the user, retrieves the corresponding product details,
     * and generates the HTML view for the wishlist.
     *
     * @return void
     */
    public function getUserWishlistData(){
        $user_id        = $this->session->userdata('userId');
        $wishlist_items = $this->Wishlist_model->getWishlistItems($user_id);
        $product_ids    = array_column($wishlist_items, 'product_id');
       
        $data['wishlists'] = $this->Product_model->getProductsByIds($product_ids);

        $viewData = $this->load->view('front/WishList/list', $data, true);
        $wishlistData = ['wishlistHtml' => $viewData,'wishCounter' => count($data['wishlists'])];
        header('Content-Type: application/json');
        echo json_encode($wishlistData);
    }

    /**
     * Adds and remove a product to the user's favorites list.
     *
     * Retrieves the product ID from the input post data and the user ID from the session.
     * Checks if the product is already in the user's wishlist.
     * If the product is in the wishlist, it is removed. If not, it is added.
     * Returns a JSON response with the total number of items in the wishlist and the type of action performed (1 for add, 2 for remove).
     */
    public function addToFaviourits(){
        $productId = $this->input->post('id');
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
            'total' => count($this->Wishlist_model->getWishlistItems($userId)),
            'type' => $type,
        ];

        // Return the data as JSON response
        $this->output->set_content_type('application/json')
            ->set_output(json_encode($responseData));
    }
}