<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ShoppingCartController class extends MY_Controller.
 * This controller handles operations related to shoppingCart.
 */
class ShoppingCartController extends MY_Controller {

    /**
     * Constructor for the ShoppingCartController class.
     * Initializes the parent constructor and loads the cart_model.
     */
    public function __construct(){
		parent::__construct();
		$this->load->model('Cart_model');
	}

    /**
     * Retrieves the shopping cart data for the current user.
     * If the user is logged in, it fetches the cart data from the database using the user ID.
     * If the user is a guest, it retrieves the cart data from the session and converts it to an array.
     * Finally, it renders the shopping cart view with the cart data.
     */
    public function shoppingCart(){
        $userId = $this->session->userdata('userId');
        $cartDataArr = [];
        if(!empty($userId)){
            $cartProducts = $this->Cart_model->getUsrCartData($userId);
        } else{
            // $cartData = $this->input->post('cartData') ?? '';
            $cartData = $this->session->userdata('cartData') ?? '';
            $userCartData = json_decode($cartData, true) ?? [];
            $cartProducts = $this->Cart_model->getGuestUserCartData($userCartData);
        }

        $this->frontRenderTemplate('front/ShoppingCart/cartData', ['cartData' => $cartProducts, 'title' => 'Shopping Cart']);
    }
}