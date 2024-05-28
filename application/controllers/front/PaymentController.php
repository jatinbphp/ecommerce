<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaymentController extends MY_Controller {

    /**
	 * The constructor function initializes a page for managing payment.
	 */
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Order_model');
		$this->load->model('Settings_model');
		$this->load->model('User_address_model');
	}

    /**
     *Process the payment using the provided data and Stripe API.
    */
	public function processPayment() {
        addPaymentLog('***********************************');
        addPaymentLog('payment-start');
		require_once('./vendor/stripe/stripe-php/init.php');
		header('Content-Type: application/json');

        # retrieve json from POST body
        // $json_str = file_get_contents('php://input');
        // $json_obj = json_decode($json_str);

        $json_obj = (object) $this->input->post();

        $stripeSecretKey = $this->Settings_model->getStripeSecretKey();
        $userId          = $this->session->userdata('userId');
        addPaymentLog("User Id: $userId");
        \Stripe\Stripe::setApiKey($stripeSecretKey);
        if($userId){
            $userData = $this->user_model->getUserData($userId);
            $userName =  $userData['first_name'] ?? '' .' '. $userData['last_name'] ?? '' ;
            $userEmail = $userData['email'] ?? '';
        } else {
            $userName = $json_obj->userName;
            $userEmail = $json_obj->email;
        }

        addPaymentLog("User Name: $userName");
        addPaymentLog("User email: $userEmail");

        if(isset($userData['stripe_customer_id']) && $userData['stripe_customer_id']){
            $stripeCustomerId = $userData['stripe_customer_id'];
        } else {
            // Add customer to stripe
            try {  
                $customer = \Stripe\Customer::create([ 
                    'name' => $userName, 
                    'email' => $userEmail
                ]); 
            }catch(Exception $e) {  
                $api_error = $e->getMessage();  
            }
            if(empty($api_error) && $customer){
                $stripeCustomerId = $customer->id;
                // update new stripe customer id on user table for this customer
                $userData = ['stripe_customer_id' => $customer->id];
                $this->user_model->edit($userData, $userId);

            }else{
                http_response_code(500);
                echo json_encode(['error' => $api_error]);
            }
        }
        addPaymentLog("User CustomerId: $stripeCustomerId");

        header('Content-Type: application/json');

        $intent = null;
        $totalAmount = $this->Order_model->getTotalAmount();
        addPaymentLog("Amount: $totalAmount");

        $address = $json_obj->address;
        $country = $json_obj->country;
        $state   = $json_obj->state;
        $city    = $json_obj->city;
        $pincode = $json_obj->pincode;
        $addressId = $json_obj->addressId;

        if($addressId){
            $addressData = $this->User_address_model->getAddressDetails($addressId);
            $address = $addressData['address_line_1'] ?? '';
            $country = $addressData['country'] ?? '';
            $state   = $addressData['state'] ?? '';
            $city    = $addressData['city'] ?? '';
            $pincode = $addressData['pincode'] ?? '';
        }

        $taxData = $this->Order_model->getTaxData($address, $city, $state, $pincode, $country);
        if($taxData && isset($taxData['tax_amount']) && $taxData['tax_amount']){
            $totalAmount += $taxData['tax_amount'];
        }
        addPaymentLog("Tax");
        addPaymentLog($taxData);

        try {
            if (isset($json_obj->payment_method_id) && $totalAmount) {
                $amount = ($totalAmount * 100);

                $isAddNewCard = $this->getAllowToAddNewCard($json_obj, $stripeCustomerId);

                if($isAddNewCard){
                    $paymentMethod = \Stripe\PaymentMethod::retrieve($json_obj->payment_method_id);
                    $paymentMethod->attach(['customer' => $stripeCustomerId]);
                }

                # Create the PaymentIntent
                $intent = \Stripe\PaymentIntent::create([
                    'payment_method' => $json_obj->payment_method_id,
                    'amount' => $amount,
                    'description' => 'Ecommerce user purchase Product.',
                    'currency' => 'usd',
                    'confirm' => true,
                    'customer' => $stripeCustomerId,
                    'automatic_payment_methods' => [
                        'enabled' => true,
                        'allow_redirects' => 'never',
                    ]
                ]);
            }
            if (isset($json_obj->payment_intent_id)) {
                $intent = \Stripe\PaymentIntent::retrieve(
                    $json_obj->payment_intent_id
                );
            }
            $this->generateResponse($intent);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            # Display error on client
            addPaymentLog("Error: ");
            addPaymentLog($e->getMessage());
            echo json_encode([
                'error' => $e->getMessage(),
            ]);
        }
        addPaymentLog('payment-end');
        addPaymentLog('***********************************');
    }

    /**
     * Generate a response based on the status of the provided PaymentIntent.
     *
     * @param $intent
     */
    public function generateResponse($intent)
    {
        # Note that if your API version is before 2019-02-11, 'requires_action'
        # appears as 'requires_source_action'.
        if ($intent->status == 'requires_action' &&
            $intent->next_action->type == 'use_stripe_sdk') {
            # Tell the client to handle the action
            echo json_encode([
                'requires_action' => true,
                'payment_intent_client_secret' => $intent->client_secret,
            ]);
        } else if ($intent->status == 'requires_capture') {
            # The payment didn’t complated yed need to capture letter with intent id!
            # Handle post-payment fulfillment
            echo json_encode([
                "success" => true,
                "intent" => $intent->id
            ]);
        } else if ($intent->status == 'succeeded') {
            # The payment didn’t need any additional actions and completed!
            # Handle post-payment fulfillment
            echo json_encode([
                "success" => true,
                "intent" => $intent->id
            ]);
        } else {
            # Invalid status
            http_response_code(500);
            echo json_encode(['error' => 'Invalid PaymentIntent status','instent_status'=> $intent->status]);
        }
    }

    /**
     * Calculate tax based on the provided address details and return the tax information in JSON format.
     * Retrieves settings data, shipping charges, address details, and tax data from the database.
     * Calculates tax amount, tax percentage, and total amount after tax including shipping charges.
     * Returns the tax information in JSON format with status, tax percentage, tax amount, and total amount after tax.
     */
    public function calculateTax() {
		header('Content-Type: application/json');
        $settingData  = $this->Settings_model->getSettingsById(1);
        $shippingCharge = $settingData['shipping_charges'] ?? 0;

        $address = $this->input->post('address');
        $country = $this->input->post('country');
        $state = $this->input->post('state');
        $city = $this->input->post('city');
        $pincode = $this->input->post('pincode');

        $taxData = $this->Order_model->getTaxData($address, $city, $state, $pincode, $country);

        $taxPercentage = $taxData['tax_percentage'] ?? 0;
        $afterTaxAmount = $taxData['after_tax_amount'] ?? 0;
        $taxAmount      = $taxData['tax_amount'] ?? 0;

        $status = 1;

        if($afterTaxAmount){
            $afterTaxAmount += $shippingCharge;
        }

        $data['status']         = $status;
        $data['taxPercentage']  = $taxPercentage;
        $data['taxAmount']      = number_format($taxAmount, 2);
        $data['afterTaxAmount'] = number_format($afterTaxAmount, 2);

        echo json_encode($data);
    }

    /**
     * Calculate tax based on the address ID provided.
     * Retrieves tax data based on the address details and calculates tax amount.
     * If no address ID is provided, returns the total amount without tax.
     * 
     * @return $this
     */
    public function calculateTaxUsingAddressId() {
        header('Content-Type: application/json');
        $settingData  = $this->Settings_model->getSettingsById(1);
        $shippingCharge = $settingData['shipping_charges'] ?? 0;

        $addressId = $this->input->post('addressId');
        
        if(!$addressId){
            $amount = $this->Order_model->getTotalAmount();
            $data['status']         = 1;
            $data['taxPercentage']  = 0;
            $data['taxAmount']      = number_format(0, 2);
            $data['afterTaxAmount'] = number_format($amount, 2);
            echo json_encode($data);
            return $this;
        }

        $addressData = $this->User_address_model->getAddressDetails($addressId);

        $address = $addressData['address_line_1'] ?? '';
        $country = $addressData['country'] ?? '';
        $state   = $addressData['state'] ?? '';
        $city    = $addressData['city'] ?? '';
        $pincode = $addressData['pincode'] ?? '';

        $taxData = $this->Order_model->getTaxData($address, $city, $state, $pincode, $country);

        $taxPercentage = $taxData['tax_percentage'] ?? 0;
        $afterTaxAmount = $taxData['after_tax_amount'] ?? 0;
        $taxAmount      = $taxData['tax_amount'] ?? 0;

        $status = 1;

        if($afterTaxAmount){
            $afterTaxAmount += $shippingCharge;
        }

        $data['status']         = $status;
        $data['taxPercentage']  = $taxPercentage;
        $data['taxAmount']      = number_format($taxAmount, 2);
        $data['afterTaxAmount'] = number_format($afterTaxAmount, 2);

        echo json_encode($data);
    }

    /**
     * Determines if a new card can be added for a customer based on the provided JSON object and customer ID.
     *
     * @param mixed $json_obj The JSON object containing payment information
     * @param int $customerId The ID of the customer
     * @return bool Returns true if a new card can be added, false otherwise
     */
    public function getAllowToAddNewCard($json_obj, $customerId) {
        $saveForLater = isset($json_obj->saveCard) ? $json_obj->saveCard : false;
        if(!$saveForLater){
            return false;
        }
        $paymentId = $json_obj->payment_method_id;
        require_once('./vendor/stripe/stripe-php/init.php');
        $stripeSecretKey = $this->Settings_model->getStripeSecretKey();
        \Stripe\Stripe::setApiKey($stripeSecretKey);

        $paymentMethod = \Stripe\PaymentMethod::retrieve($paymentId);

        if(empty($paymentMethod) || !isset($paymentMethod['card'])){
            return false;
        }

        $currentCardNumber = $paymentMethod['card']['last4'] ?? 0;
        
        if(!$currentCardNumber){
            return false;
        }

        $existingCards = $this->existingCardData($customerId);

        if(in_array($currentCardNumber, $existingCards)){
            return false;
        }

        return true;
    }

    /**
     * Retrieves the existing card data for a given customer ID from the Stripe API.
     *
     * This method initializes the Stripe API client, retrieves all payment methods associated with the customer ID,
     * and extracts the last 4 digits of the card numbers for each payment method.
     *
     * @param string $customerId The ID of the customer for whom to retrieve the card data.
     * @return array An array containing the last 4 digits of the card numbers associated with the customer.
     */
    public function existingCardData($customerId) {
        require_once('./vendor/stripe/stripe-php/init.php');
        $stripeSecretKey = $this->Settings_model->getStripeSecretKey();
        $stripe = new \Stripe\StripeClient($stripeSecretKey);

        $allPayments = $stripe->paymentMethods->all([
            'customer' => $customerId,
            'type' => 'card',
        ]);

        if(empty($allPayments)){
            return [];
        }

        $cardNumbers = [];

        foreach ($allPayments as $cardData) {
            $cardData = $cardData['card'] ?? [];
            if(!count($cardData)){
                continue;
            }

            $cardNumbers[] = $cardData['last4'];
        }

        return $cardNumbers;
    }
}