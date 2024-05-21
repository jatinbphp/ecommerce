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
        $this->load->model('Order_options_model');
        $this->load->model('ProductImage_model');
        $this->load->model('Settings_model');
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
        $settingData = $this->Settings_model->getSettingsById(1);
        $cancelOrderDays = $settingData['order_cancel_period'] ?? 0;

		foreach ($allData as $row) {
			$orderData = [];
            
            $userData   = $this->User_model->getUserData($row->user_id);
            $orderItems = $this->Order_items_model->getOrderItemsByOrderId($row->id);

           $cancellationDeadline = date('Y-m-d H:i:s', strtotime($row->created_at . " + $cancelOrderDays days"));
           $currentDate = date('Y-m-d H:i:s');
            
            $row->isCancelShow = false;

            if ($currentDate < $cancellationDeadline) {
                if($row->status == $this->Order_model::STATUS_TYPE_PENDING){
                    $row->isCancelShow = true;
                }
            }

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
        $orderAttributes = $this->Order_options_model->getOrderItemsByOrderId($id);
        $address    = $this->User_address_model->getAddressDetails($order->address_id);
         
        $data['order']      = $order;
        $data['user']       = $user;
        $data['orderItems'] = $orderItems;
        $data['orderAttributes'] = $orderAttributes;

        $this->frontRenderTemplate('front/myAccount/myOrders/orderDetails', $data);
    }

    /**
     * Cancels an order by updating its status and adding cancellation reason.
     *
     * This method cancels an order by setting its status to cancelled and adding a cancellation reason.
     * If the order is in pending status, it also refunds the payment (if applicable) and sends a cancellation email.
     *
     * @return string JSON-encoded data containing the updated order status and cancellation details
     */
    public function cancelOrder() {
        $data['status'] = 0;
		$orderId = $this->input->post('id');
		$reason = $this->input->post('reason');
        $order = $this->Order_model->getDetails($orderId);
 
        if (!empty($order) && isset($order['status']) && $order['status'] == $this->Order_model::STATUS_TYPE_PENDING) {
            $data = [
                'cancellation_reason' => $reason,
                'status' => $this->Order_model::STATUS_TYPE_CANCEL
            ];
            if(isset($order['payment_intent_id']) && $order['payment_intent_id']){
                $cancelOrderData = $this->Order_model->refundAmount($order['payment_intent_id']);
                if($cancelOrderData && isset($cancelOrderData['refund_id'])){
                    $data['payment_refund_id'] = $cancelOrderData['refund_id'];
                }
                $this->Order_model->sendOrderStatusMail($orderId, $this->Order_model::STATUS_TYPE_CANCEL);
            }
            
            $this->Order_model->edit($data, $orderId);
            $data['status'] = 1;
        }

		return $this->output->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}