<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* This class extends the MY_Controller class and likely contains methods and properties specific to
Orders tasks. */
class OrdersController extends MY_Controller
{
	/**
	 * The constructor function initializes the Categories page with necessary data and checks if the
	 * admin is logged in.
	 */
	public function __construct(){
		parent::__construct();
		$this->checkAdminLoggedIn();
		$this->data['page_title'] = 'Orders';
		$this->load->model('order_model');
	}

	/**
	 * The index function renders the admin template for displaying orders data.
	 */
	public function index(){
		$this->adminRenderTemplate('admin/Orders/index', $this->data);
	}

	/**
	 * The fetchOrders function retrieves orders data and formats it for display in a DataTable.
	 */
	public function fetchOrders()
	{
		$data    = [];
		$allData = $this->order_model->make_order_datatables();

		foreach ($allData as $row) {
			$totalAmount = number_format(($row->total_amount + $row->shipping_cost + $row->tax_amount), 2);
			$data[] = [
				'payment_intent_id' => $row->payment_intent_id,
				'id' => $row->id,
				'order_id' => '#' . $row->id,
				'user_name' => $row->user_name,
				'total_amount' => '$'.$totalAmount,
				'card_brand' => '',
				'card_number' => '',
				'card_exp' => '',
				'status' => $this->getOrderStatus($row),
				'created_at' => date('Y-m-d h:i:s', strtotime($row->created_at)),
				'action' => '<div class="btn-group btn-group-sm">
									<a href="javascript:void(0)" title="View Order" data-id="'.$row->id.'" class="btn btn-sm btn-warning tip view-info" data-url="'.base_url("admin/dashboard/order/show/$row->id").'" data-title="Order Details">
										<i class="fa fa-eye"></i>
									</a>
								</div>',		
			];
		}

		$output = [
			"draw"            => intval(isset($_POST["draw"]) ? $_POST["draw"] : 0),
			"recordsTotal"    => $this->order_model->get_all_order_data(),
			"recordsFiltered" => $this->order_model->get_filtered_order_data(),
			"data"            => $data,
		];
		echo json_encode($output);
	}

	/**
	 * Get the HTML select element for changing the order status based on the provided row.
	*
	* @param  object  $row
	* @return string
	*/
	public function getOrderStatus($row) {
		$disabled = 'disabled';
		if($row->status==='pending'){
			$disabled = '';
		}

		$select = '<select '.$disabled.' class="form-control select2 orderStatus" id="status'.$row->id.'"  data-id="'.$row->id.'" >';
			foreach($this->order_model::$allStatus as $key => $status){
				$selected = ($key == $row->status) ? ' selected="selected"' : '';
				$select .= '<option '.$selected.' value="'.$key.'">'.ucfirst($status).'</option>';
			}
		$select .= '</select>';
		return $select;
	}

	/**
	 * Updates the status of an order based on the input data.
	* 
	* This method retrieves the order details based on the provided order ID, 
	* checks if the order is pending, and updates the status accordingly. 
	* If the status is set to cancel, it refunds the payment amount if applicable 
	* and sends an order status mail. If the status is set to complete, it sends 
	* an order status mail. Finally, it updates the order status in the database 
	* and returns the updated status in JSON format.
	* 
	* @return void
	*/
	public function updateStatus()
    { 
        $data['status'] = 0;
		$orderId = $this->input->post('id');
		$status = $this->input->post('status');
        $order = $this->order_model->getDetails($orderId);
        
        if (!empty($order) && isset($order['status']) && $order['status'] == 'pending') {
			$data = ['status' => $status];
			if($status == $this->order_model::STATUS_TYPE_CANCEL){
				if(isset($order['payment_intent_id']) && $order['payment_intent_id']){
					$cancelOrderData = $this->order_model->refundAmount($order['payment_intent_id']);
					if($cancelOrderData && isset($cancelOrderData['refund_id'])){
						$data['payment_refund_id'] = $cancelOrderData['refund_id'];
					}
				}
				$this->order_model->sendOrderStatusMail($orderId, $status);
			} elseif($status == $this->order_model::STATUS_TYPE_COMPLETE){
				$this->order_model->sendOrderStatusMail($orderId, $status);
			}
			$this->order_model->edit($data, $orderId);
            $data['status'] = 1;
        }

		return $this->output->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

	/**
	 * Retrieve and return card details based on the payment intent ID.
	 *
	 * This method fetches the payment intent ID from the GET parameters and uses it 
	 * to retrieve the associated card details from the database. The card details 
	 * are fetched using the `getCardDetialsBasedOnPaymentIntentId` method of the 
	 * `order_model`.
	 *
	 * The response includes the card details and a status flag indicating whether 
	 * the retrieval was successful. The response format is as follows:
	 * 
	 * If the payment intent ID is provided:
	 * {
	 *     "status": 1,
	 *     "card_data": "card_details_here"
	 * }
	 * 
	 * If the payment intent ID is missing:
	 * {
	 *     "status": 0
	 * }
	 *
	 * @return CI_Output JSON response containing the card details and status flag.
	 */

    public function getCardDetails()
    {
    	$paymentIntentId = $this->input->get('payment_intent_id');
    	if(empty($paymentIntentId)){
    		$data['status'] = 0;
    	}else{
    		$data['card_data'] = $this->order_model->getCardDetialsBasedOnPaymentIntentId($paymentIntentId);
    		$data['status'] = 1;
    	}
    	return $this->output->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}