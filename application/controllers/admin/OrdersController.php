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
			$orderData = [];
			$orderData[] = "#".$row->id;
			$orderData[] = $row->id;
			$orderData[] = $row->user_name;
			$orderData[] = '$'.$totalAmount;
			$orderData[] = $this->getOrderStatus($row);
			$orderData[] = $row->created_at;
			$orderData[] = '<div class="btn-group btn-group-sm">
									<a href="javascript:void(0)" title="View Order" data-id="'.$row->id.'" class="btn btn-sm btn-warning tip view-info" data-url="'.base_url("admin/dashboard/order/show/$row->id").'" data-title="Order Details">
										<i class="fa fa-eye"></i>
									</a>
								</div>';

			$data[] = $orderData;
		}

		$output = [
			"draw"            => intval($_POST["draw"]),
			"recordsTotal"    => $this->order_model->get_all_order_data(),
			"recordsFiltered" => $this->order_model->get_filtered_order_data(),
			"data"            => $data,
		];
		echo json_encode($output);
	}

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
			}
			$this->order_model->edit($data, $orderId);
            $data['status'] = 1;
        }

		return $this->output->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}