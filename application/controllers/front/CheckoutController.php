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
        $this->load->model('Settings_model');
        $this->load->model('Countries_model');
        $this->load->model('User_model');
        $this->load->library('email');
    }

    /**
     * Retrieves user addresses and cart products data to display on the checkout page.
     * If the user is not logged in, it retrieves cart data from the guest user.
     */
    public function index() {
        $userId = $this->session->userdata('userId');
        $this->data['user_billing_addresses'] = $this->User_address_model->getUserAddressesByType($userId, $this->User_address_model::ADDRESS_TYPE_BILLING);
        $this->data['user_shipping_addresses'] = $this->User_address_model->getUserAddressesByType($userId, $this->User_address_model::ADDRESS_TYPE_SHIPPING);
        $cartProducts = $this->Cart_model->getUsrCartData($userId);
        $settingData  = $this->Settings_model->getSettingsById(1);
        if(!$userId){
            $cartData = $this->session->userdata('cartData') ?? '';
            $userCartData = json_decode($cartData, true) ?? [];
            $cartProducts = $this->Cart_model->getGuestUserCartData($userCartData);
        }
        $this->data['userEmail'] = '';
        if($userId){
            $userData = $this->user_model->getUserData($userId);
            $this->data['userEmail'] = $userData['email'] ?? '';
        }
        $this->data['cart_products'] = $cartProducts;
        $this->data['userCardData'] = $this->getCardData($userId);
        $this->data['shippingCharge'] = $settingData['shipping_charges'] ?? 0;
        $this->data['stripe_publishable_key'] = $this->Settings_model->getStripePublishableKey();
        $this->data['countries'] = $this->Countries_model->getCountrCodeWiseCountry();
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
            $cartData = $this->session->userdata('cartData') ?? '';
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
            'payment_intent_id'  => $this->input->post('pay_intent'),
            'tax_percentage' => 0,
            'tax_amount' => 0,
        ];

        $addressId = $this->input->post('address_id');
        $shippingAddressId = $this->input->post('shipping_address_id');
        $orderInputs['address_id'] = $addressId;
        $orderInputs['shipping_address_id'] = $shippingAddressId;
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
            $addressData['email'] = $orderData['email'] ?? '';
            $orderInputs['address_info'] = json_encode($addressData);

            $address = $addressData['address_line1'] ?? '';
            $country = $addressData['country'] ?? '';
            $state   = $addressData['state'] ?? '';
            $city    = $addressData['city'] ?? '';
            $pincode = $addressData['pincode'] ?? '';

            $taxData = $this->Order_model->getTaxData($address, $city, $state, $pincode, $country);
        } else {
            $addressData = $this->User_address_model->getAddressDetails($addressId);

            $address = $addressData['address_line_1'] ?? '';
            $country = $addressData['country'] ?? '';
            $state   = $addressData['state'] ?? '';
            $city    = $addressData['city'] ?? '';
            $pincode = $addressData['pincode'] ?? '';
    
            $taxData = $this->Order_model->getTaxData($address, $city, $state, $pincode, $country);
        }

        if(isset($taxData)){
            $orderInputs['tax_percentage'] = $taxData['tax_percentage'] ?? 0;
            $orderInputs['tax_amount'] = $taxData['tax_amount'] ?? 0;
        }

        if($shippingAddressId == 0){
            $addressData = [
                'user_id'       => $userId,
                'title'         => $orderData['shipping_title'] ?? '',
                'first_name'    => $orderData['shipping_first_name'] ?? '',
                'last_name'     => $orderData['shipping_last_name'] ?? '',
                'company'       => $orderData['shipping_company'] ?? '',
                'mobile_phone'  => $orderData['shipping_mobile_phone'] ?? '',
                'address_line1' => $orderData['shipping_address_line1'] ?? '',
                'address_line2' => $orderData['shipping_address_line2'] ?? '',
                'country'       => $orderData['shipping_country'] ?? '',
                'state'         => $orderData['shipping_state'] ?? '',
                'city'          => $orderData['shipping_city'] ?? '',
                'pincode'       => $orderData['shipping_pincode'] ?? '',
                'additional_information' => $orderData['shipping_additional_information'] ?? '',
                'address_type' => $this->User_address_model::ADDRESS_TYPE_SHIPPING,
            ];
            if($userId){
                $newAddress = $this->User_address_model->createByUser($addressData);
                $orderInputs['shipping_address_id'] = $newAddress;
            }
            $orderInputs['shipping_address_info'] = json_encode($addressData);
        } else {
            $addressData = $this->User_address_model->getAddressDetails($addressId);

            $address = $addressData['address_line_1'] ?? '';
            $country = $addressData['country'] ?? '';
            $state   = $addressData['state'] ?? '';
            $city    = $addressData['city'] ?? '';
            $pincode = $addressData['pincode'] ?? '';
    
            $taxData = $this->Order_model->getTaxData($address, $city, $state, $pincode, $country);
        }

        $settingData  = $this->Settings_model->getSettingsById(1);
        $orderInputs['shipping_cost']  = $settingData['shipping_charges'] ?? 0;
        
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
        $shippingAddress = $this->User_address_model->getAddressDetails($shippingAddressId);
        if($shippingAddress && $userId){
            $newOrderData['shipping_address_info'] = json_encode($shippingAddress);
        }
        $newOrderData['total_amount'] = $orderTotal;
        $newOrderData['status'] = 'pending';
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
        $this->sendOrderConfirmationMail($orderId);
        $this->frontRenderTemplate('front/Checkout/orderComplete', $data);
    }

    /**
     * Sends an order confirmation email to the user associated with the given order ID.
     *
     * Retrieves order details, status data, order data with items and options, and user data.
     * Constructs an email message using the order confirmation email template.
     * Determines the recipient email address from user data or order address information.
     * Sends the email with the order confirmation message.
     *
     * @param int $orderId The ID of the order for which the confirmation email is being sent.
     * @return $this
     */
    public function sendOrderConfirmationMail($orderId) {
        $orderData = $this->Order_model->getDetails($orderId);
		$data['status'] = $this->Order_model->getStatusData();
		$data['orderData'] = $this->Order_model->getOrderWithItemsAndOptions($orderId);
		$userData = [];
		if(isset($orderData['user_id']) && $orderData['user_id']){
			$userData = $this->user_model->getUserData($orderData['user_id']);
		}
		$data['userData'] = $userData;
        $message = $this->load->view('front/EmailTemplates/orderConfirmationEmail', $data, true);

        $email = '';

        if(isset($userData['email']) && $userData['email']){
            $email = $userData['email'];

        } else {
            $address = json_decode(($orderData['address_info'] ?? ''), true);
            $email = isset($address['email']) && $address['email'] ? $address['email'] : '';
        }

        if($email){
            $this->email->from('noreply@gorentonline.com', 'Order Confirmation');
            $this->email->to($email);
            $this->email->subject("Order Confirmation - #$orderId");
            $this->email->message($message);
            $this->email->send();
        }
        return $this;
    }

    /**
     * Retrieves card data associated with the given user ID.
     *
     * If the user ID is empty, an empty array is returned.
     * If the user has no associated Stripe customer ID, an empty array is returned.
     * Retrieves payment methods from Stripe using the customer ID and filters by card type.
     * If no payment methods are found, an empty array is returned.
     * Extracts and structures card data including brand and last 4 digits from payment methods.
     *
     * @param int $userId The ID of the user
     * @return array An array containing card data with keys as payment IDs and values as arrays with 'brand' and 'last4' keys
     */
    public function getCardData($userId) {
        if(!$userId){
            return [];
        }
        $userData = $this->user_model->getUserData($userId);
        $customerId = $userData['stripe_customer_id'] ?? '';
        if(!$customerId){
            return [];
        }
        require_once('./vendor/stripe/stripe-php/init.php');
        $stripeSecretKey = $this->Settings_model->getStripeSecretKey();
        $stripe = new \Stripe\StripeClient($stripeSecretKey);

        $paymentMethods = $stripe->paymentMethods->all([
            'customer' => $customerId,
            'type' => 'card',
        ]);

        if(empty($paymentMethods)){
            return [];
        }

        $cardData = [];

        foreach ($paymentMethods as $payment) {
            $paymentId = $payment['id'] ?? 0;
            if(!$paymentId){
                continue;
            }
            
            $brand = $payment['card']['brand'] ?? '';
            $last4 = $payment['card']['last4'] ?? '';

            $cardData[$paymentId]['brand'] = ucfirst($brand);
            $cardData[$paymentId]['last4'] = $last4;
        }
        
        return $cardData;
    }
}