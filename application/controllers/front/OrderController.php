<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrderController extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->checkUserLoggedIn();
        $this->load->model('Order_model');
        $this->load->model('User_model');
        $this->load->model('User_address_model');
        $this->load->model('Order_items_model');
        $this->load->model('ProductImage_model');
    }

    public function index() {
        $data['title']= "My Orders";
        $this->frontRenderTemplate('front/myAccount/myOrders/orders', $data);
    }
        
    public function fetchOrders()
    {
        $data    = [];
		$allData = $this->Order_model->make_datatables();

		foreach ($allData as $row) {
			$orderData = [];
            
            $userData   = $this->User_model->getUserData($row->user_id);
            $orderItems = $this->Order_items_model->getOrderItemsByOrderId($row->id);
            
            $row->orderItems=count($orderItems);
            $row->user = $userData;

			$orderData[] = "#".$row->id;   
			$orderData[] = $this->load->view('front/myAccount/myOrders/orderInfo', $row, true);
            
			$data[] = $orderData;
		}

		$output = [
			"draw"            => intval($_POST["draw"]),
			"recordsTotal"    => $this->Order_model->get_all_data(),
			"recordsFiltered" => $this->Order_model->get_filtered_data(),
			"data"            => $data,
		];
		echo json_encode($output);
    }

    public function orderDetails($id)
    {
        $data['title']= "My Orders";
        
        $order      = $this->Order_model->getOrderById($id);
        $user       = $this->User_model->getUserData($order->user_id);
        $orderItems = $this->Order_items_model->getOrderItemsByOrderId($id);
        $address    = $this->User_address_model->getAddressDetails($order->address_id);
         
        $data['order']      = $order;
        $data['user']       = $user;
        $data['orderItems'] = $orderItems;
        $data['address']    = $address;

        $this->frontRenderTemplate('front/myAccount/myOrders/orderDetails', $data);
    }
}