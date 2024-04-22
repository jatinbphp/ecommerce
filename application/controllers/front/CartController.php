<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CartController class extends MY_Controller.
 * This class is responsible for handling cart-related operations.
 */
class CartController extends MY_Controller {
 /**
  * Constructor for the Cart class.
  * Initializes the parent class and loads the Cart_model.
  */
	public function __construct() {
        parent::__construct();
        $this->load->model('Cart_model');
    }


    public function addToCartProduct()
    {
         //remain to here necessary validation complete after quick view
         //$this->form_validation->set_rules('options[]', 'Options', 'callback_options_check');

        $userId = $this->session->userdata('userId');
        $productId = $this->input->post('productId');
        $options = $this->input->post('options');
        $productQty = $this->input->post('prodQty');

        if(isset($userId) && $userId != '')
        {
            $this->db->select('*');
            $this->db->from('carts');
            $this->db->where('user_id', $userId);
            $this->db->where('product_id', $productId);
            $this->db->where('options', json_encode($options));
            $this->db->limit(1);

            $query = $this->db->get();

            $cartRows = $query->row();

            $cart = $query->num_rows();

            if($cart == 0){
                $cartData = [
                    'user_id' => $userId,
                    'options' => json_encode($options),
                    'product_id' => $productId,
                    'quantity' => $productQty
                ];
                $this->Cart_model->create($cartData);
            }
            else
            {
                $newQuantity = $cartRows->quantity + $productQty;
                $this->db->where('user_id', $userId);
                $this->db->where('product_id', $productId);
                $this->db->where('options', json_encode($options));
                $this->db->update('carts', array('quantity' => $newQuantity));
            }

            $cartCounter = $this->Cart_model->cartCounter($userId);
        }
        else
        {
             $guestCartData = array(
                'productId' => $productId,
                'options' => $options,
                'prodQty' => $productQty
            );
                
            $cart = $this->session->userdata('guestCart');

            if ($cart) {
                $itemExists = false;
                foreach ($cart as $key => $item) {
                    if ($item['productId'] == $guestCartData['productId'] && $item['options'] == $guestCartData['options']) {
                        $cart[$key]['prodQty'] += $guestCartData['prodQty'];
                        $itemExists = true;
                        break;
                    }
                }

                if (!$itemExists) {
                   $cart[] = $guestCartData;
                }
                
            } else {
                $cart = array($guestCartData);
            }

            $this->session->set_userdata('guestCart', $cart); 

            //for common function to add in cart for guest user
            //$this->addToGuestCart($guestCartData);

            if ($this->session->has_userdata('guestCart')) {
                $guestCart = $this->session->userdata('guestCart');
                $cartCounter = count($guestCart);
            }
            else
            {
                $cartCounter = 0;
            }
        }

        $this->output->set_content_type('application/json')
            ->set_output(json_encode($cartCounter));
    
    }

    public function getUserCartData()
    {
        $userId = $this->session->userdata('userId');

        if(isset($userId) && $userId != '')
        {
            $getCartUsrData = $this->Cart_model->getUsrCartData($userId);
            $getViewData = $this->load->view('front/Cart/userCartView',['cartData' => $getCartUsrData],true);
            $cartCounter = count($getCartUsrData);
            $cartDataArr = ['cartView' => $getViewData,'cartCounter' => $cartCounter];
            header('Content-Type: application/json');
            echo json_encode($cartDataArr);
        }
        else
        {
            $guestCartData = $this->session->userdata('guestCart');

            if ($guestCartData !== FALSE) {
                    // Guest cart data exists, you can use it here
                    $getViewData = $this->load->view('front/Cart/userCartView', ['cartData' => $guestCartData], true);
                    $cartCounter = count($getViewData);
                    $cartDataArr = ['cartView' => $getViewData,'cartCounter' => $cartCounter];
                    header('Content-Type: application/json');
                    echo json_encode($cartDataArr);

                } else {

                    // No data for guest user so display default cart for your cart is empty view here
            }

        }

    }

    public function deleteUserCartItem()
    {
        $cartId = $this->input->post('cartId');

        if(isset($cartId))
        {
            $getDelCnt = $this->Cart_model->deleteCartItem($cartId);

            return $this->getUserCartData();
        }
        
    }


}