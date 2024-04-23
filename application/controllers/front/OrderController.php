<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class OrderController
 *
 * This class extends the MY_Controller class and serves as the controller for handling orders.
 */
class OrderController extends MY_Controller {

    /**
     * Constructor for the class. 
    * Initializes the parent class and loads necessary models for further operations.
    * Checks if the user is logged in before proceeding.
    */
	public function __construct() {
        parent::__construct();
        $this->checkUserLoggedIn();
        $this->load->model('Order_model');
        $this->load->model('User_model');
        $this->load->model('User_address_model');
        $this->load->model('Order_items_model');
        $this->load->model('ProductImage_model');
    }

    /**
     * Renders the 'My Orders' page with the specified title.
     *
     * @return void
     */
    public function index() {
        $data['title']= "My Orders";
        $this->frontRenderTemplate('front/myAccount/myOrders/orders', $data);
    }
        
    /**
     * Fetches orders data including user information and order items.
     * Retrieves orders data from the Order_model, user data from the User_model,
     * and order items data from the Order_items_model.
     * Constructs an array of order data including order ID, user information, and order items.
     * Returns the data in JSON format with draw, recordsTotal, recordsFiltered, and data fields.
     */
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

    /**
     * Retrieve and display the details of a specific order.
     *
     * @param int $id The ID of the order to retrieve details for
     * @return void
     */
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