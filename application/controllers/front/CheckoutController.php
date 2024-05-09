<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* This class extends the MY_Controller class and likely handles contact us functionality. */
class CheckoutController extends MY_Controller {

    protected $data = [];
    public function __construct() {
        parent::__construct();
        $this->data['title'] = 'Checkout';
        $this->load->model('User_address_model');
        $this->load->model('Cart_model');
        $this->load->model('Order_model');
        $this->load->model('Order_items_model');
        $this->load->model('Order_options_model');
        $this->load->model('ProductOptions_model');
        $this->load->model('ProductOptionValues_model');
    }

    /**
     * Retrieves user addresses and cart products data to display on the checkout page.
     * If the user is not logged in, it retrieves cart data from the guest user.
     */
    public function index() {
        $userId = $this->session->userdata('userId');
        $this->data['user_addresses'] = $this->User_address_model->getUserAddresses($userId);
        $cartProducts = $this->Cart_model->getUsrCartData($userId);
        if(!$userId){
            $cartData = $this->session->userdata('cartData') ?? '';
            $userCartData = json_decode($cartData, true) ?? [];
            $cartProducts = $this->Cart_model->getGuestUserCartData($userCartData);
        }
        $this->data['cart_products'] = $cartProducts;
        $this->frontRenderTemplate('front/Checkout/userCheckout', $this->data);
    }

    /**
     * Place an order with the provided order data.
     * 
     * This method processes the order placement by collecting necessary data, creating the order, 
     * and saving order items and options. It also handles user and guest user scenarios for address information.
     * 
     * @return void
     */
    public function orderPlace(){
        $orderData = $this->input->post();
        $userId = $this->session->userdata('userId');
        $orderProducts = $this->Cart_model->getUsrCartData($userId);
        if(!$userId){
            $userId = 0;
            $cartData = $this->input->post('cartData') ?? '';
            $userCartData = json_decode($cartData, true) ?? [];
            $orderProducts = $this->Cart_model->getGuestUserCartData($userCartData);
        }
        
        if(empty($orderProducts)){
            $this->session->set_flashdata('error', 'Something went wrong. Please try again!');
            redirect('checkout');
        }

        $orderInputs = [
            'user_id' => $userId,
            'delivey_method' => $this->input->post('delivery_method'),
            'notes' => $this->input->post('notes'),
        ];

        $addressId = $this->input->post('address_id');
        $orderInputs['address_id'] = $addressId;
        if($addressId == 0){
            $addressData = [
                'user_id'       => $userId,
                'title'         => $orderData['title'] ?? '',
                'first_name'    => $orderData['first_name'] ?? '',
                'last_name'     => $orderData['last_name'] ?? '',
                'company'       => $orderData['company'] ?? '',
                'mobile_phone'  => $orderData['mobile_phone'] ?? '',
                'address_line1' => $orderData['address_line1'] ?? '',
                'address_line2' => $orderData['address_line2'] ?? '',
                'country'       => $orderData['country'] ?? '',
                'state'         => $orderData['state'] ?? '',
                'city'          => $orderData['city'] ?? '',
                'pincode'       => $orderData['pincode'] ?? '',
                'additional_information' => $orderData['additional_information'] ?? '',
            ];
            if($userId){
                $newAddress = $this->User_address_model->createByUser($addressData);
                $orderInputs['address_id'] = $newAddress;
            }
            $orderInputs['address_info'] = json_encode($addressData);
        }
        
        $order = $this->Order_model->create($orderInputs);

        $orderTotal = 0;
        foreach ($orderProducts as $key => $data) {
            $productData = $data['cart_data']['productData'] ?? [];
            $productId = ($productData['product_id'] ?? 0);
            if(!$productId){
                continue;
            }
            $subTotal = (($productData['price'] ?? 0)* ($productData['quantity']));
            $orderTotal += $subTotal;
            $inputOrderOptionsItem = [
                'order_id'      => $order,
                'product_id'    => $productId,
                'product_name'  =>($productData['product_name'] ?? ''),
                'product_sku'   => ($productData['sku'] ?? ''),
                'product_price' => ($productData['price'] ?? 0),
                'product_qty'   => ($productData['quantity'] ?? 0),
                'sub_total'     => $subTotal,
            ];

            $orderItem = $this->Order_items_model->create($inputOrderOptionsItem);
            $options = [];
            if(isset($productData['options'])){
                $options = json_decode($productData['options'], true);
            }

            if(!empty($options)){
                foreach ($options as $optionsId => $valueId) {
                    $productOption = $this->ProductOptions_model->getOption($optionsId);
                    $productOptionValue = $this->ProductOptionValues_model->getOptionValue($valueId);
                    $inputOrderOption = [
                        'order_id' => $order,
                        'order_product_id' => $orderItem,
                        'product_option_id' => $optionsId,
                        'product_option_value_id' => $valueId,
                        'name' => ($productOption['option_name'] ?? ''),
                        'value' => ($productOptionValue['option_value'] ?? ''),
                        'price' => ($productOptionValue['option_price'] ?? ''),
                    ];
                    $this->Order_options_model->create($inputOrderOption);
                }
            }
        }

        $address = $this->User_address_model->getAddressDetails($addressId);

        if($address && $userId){
            $newOrderData['address_info'] = json_encode($address);
        }
        $newOrderData['total_amount'] = $orderTotal;
        $newOrderData['status'] = 'complete';
        if($order){
            $this->Order_model->edit($newOrderData, $order);
        }

        $this->Cart_model->deleteByUserId($userId);
        $this->orderCompleted($order);
    }

    /**
     * Mark an order as completed and display the order completion page.
     *
     * @param int $orderId The ID of the order to mark as completed
     * @return void
     */
    public function orderCompleted($orderId){  
         
        $data['title'] = 'Order Completed';
        $order = $this->Order_model->getOrderById($orderId);

        if(empty($order)){
            $this->session->set_flashdata('error', 'Your account needs to be updated with the orders.');
            redirect('checkout');
        }

        $data['order_id'] = $orderId;
        $this->frontRenderTemplate('front/Checkout/orderComplete', $data);
    }
}