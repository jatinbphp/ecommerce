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
        $userId = $this->session->userdata('userId');
        $productId = $this->input->post('product_id');
        $options = $this->input->post('options');
        $productQty = $this->input->post('quantity');

        if(empty($productId) || empty($options) || empty($productQty)){
            return $this->output->set_content_type('application/json')
            ->set_output(json_encode(['type' => 2]));
        }

        $data['type'] = 1;
        if(!empty($userId)){
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
            } else {
                $newQuantity = $cartRows->quantity + $productQty;
                $this->db->where('user_id', $userId);
                $this->db->where('product_id', $productId);
                $this->db->where('options', json_encode($options));
                $this->db->update('carts', array('quantity' => $newQuantity));
            }
            $cartCounter = $this->Cart_model->cartCounter($userId);
            $data['cartCounter'] = $cartCounter;

            return $this->output->set_content_type('application/json')
            ->set_output(json_encode($data));
        }
                
        $addCartData = [
            'product_id' => $productId,
            'options' => $options,
            'quantity' => $productQty
        ];
        
        $data['type'] = 3;
        $data['addCartData'] = $addCartData;

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function getUserCartData()
    {
        $userId = $this->session->userdata('userId');
        $cartDataArr = [];
        if(!empty($userId))
        {
            $userCartData = $this->Cart_model->getUsrCartData($userId);
            $viewData = $this->load->view('front/Cart/userCartView',['cartData' => $userCartData],true);
            $cartCounter = count($userCartData);
            
            $cartDataArr = [
                'cartView' => $viewData,
                'cartCounter' => $cartCounter
            ];
        } else{
            $cartData = $this->input->post('cartData') ?? '';
            $userCartData = json_decode($cartData, true) ?? [];
            $cartProducts = $this->Cart_model->getGuestUserCartData($userCartData);

            $viewData = $this->load->view('front/Cart/userCartView',['cartData' => $cartProducts],true);
            $cartCounter = count($userCartData);
            $cartDataArr = [
                'cartView' => $viewData,
                'cartCounter' => $cartCounter
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($cartDataArr);
    }

    public function getProductIdWiseOptions($data) {
        if(!$data){
            return [];
        }

        $productWiseData = [];
        foreach($data as $cartData){
            $userCartData = [];
            $productId = ($cartData['product_id'] ?? 0);
            if(!$productId){
                continue;
            }

            $userCartData['options'] = $cartData['options'] ?? [];
            $userCartData['quantity'] = $cartData['quantity'] ?? 0;
        
            $productWiseData[$productId][] = $userCartData;
        }

        return $productWiseData;
    }

    public function deleteUserCartItem()
    {
        $cartId = $this->input->post('cartId');

        if(isset($cartId))
        {
            $this->Cart_model->deleteCartItem($cartId);
            return $this->getUserCartData();
        }
        
    }


}