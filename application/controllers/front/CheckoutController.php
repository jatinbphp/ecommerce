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
        $this->load->model('User_address_model');
        $this->load->model('Order_model');
    }

    public function index() {
        $userId = $this->session->userdata('userId');
        $this->data['user_addresses'] = $this->User_address_model->getUserAddresses($userId);
        $this->data['cart_products'] = $this->Cart_model->getUsrCartData($userId);
        $this->frontRenderTemplate('front/Checkout/userCheckout', $this->data);
    }

    public function orderPlace(){
        $orderData = $this->input->post();
        $userId = $this->session->userdata('userId');
        $orderProducts = $this->Cart_model->getUsrCartData($userId);
        
        if(empty($orderProducts)){
            $this->session->set_flashdata('error', 'Something went wrong. Please try again!');
            redirect('checkout');
        }

        $orderData['user_id'] = $userId;

        if($this->input->post('address_id') == 0){
            $newAddress = $this->User_address_model->createByUser($input);
            $input['address_id'] = $newAddress['id'];
        }
        
        //$order = $this->Order_model->create($input);

        $orderTotal = 0;
        // echo "<pre>";
        // print_r($orderProducts);
        // die;
        foreach ($orderProducts as $key => $data) {
            echo "<pre>";
            print_r($data);
            die;

            $orderTotal += ($value->product->price*$value->quantity);
            $inputOrderItem = [
                'order_id' => $order->id,
                'product_id' => $value->product_id,
                'product_name' => $value->product->product_name,
                'product_sku' => $value->product->sku,
                'product_price' => $value->product->price,
                'product_qty' => $value->quantity,
                'sub_total' => ($value->product->price*$value->quantity),
            ];
            $OrderItem = OrderItem::create($inputOrderItem);

            $options = json_decode($value->options);
            if(!empty($options)){
                foreach ($options as $keyO => $valueO) {

                    $product_option = ProductsOptions::where('id',$keyO)->first();
                    $product_option_value = ProductsOptionsValues::where('id', $valueO)->first();
                    $inputOrderOption = [
                        'order_id' => $order->id,
                        'order_product_id' => $OrderItem->id,
                        'product_option_id' => $keyO,
                        'product_option_value_id' => $valueO,
                        'name' => $product_option->option_name,
                        'value' => $product_option_value->option_value,
                        'price' => $product_option_value->option_price,
                    ];
                    OrderOption::create($inputOrderOption);
                }
            }
        }

        //update total in order table
        $address = UserAddresses::findOrFail($input['address_id']);
        $order['address_info'] = json_encode($address);
        $order['total_amount'] = $orderTotal;
        $order['status'] = 'complete';
        $order->save();

        // clear cart
        Cart::where('user_id',Auth::user()->id)->delete();

        return redirect()->route('checkout.order-completed');
    }
}