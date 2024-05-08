<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * DashboardController class extends MY_Controller.
 *
 * This class serves as the controller for the dashboard functionality of the application.
 * It inherits properties and methods from the MY_Controller class.
 */
class DashboardController extends MY_Controller {

 /**
  * Constructor method for the class.
  * It initializes the parent constructor, checks if the admin is logged in,
  * loads the user_model, and checks if the admin is logged in again.
  */
	public function __construct() {
		parent::__construct();
		$this->checkAdminLoggedIn();
		$this->load->model('Order_model');
		$this->load->model('Order_options_model');
		$this->load->model('Product_model');
		$this->load->model('ProductImage_model');
		$this->load->model('user_model');
		$this->load->model('Order_model');
		$this->checkAdminLoggedIn();
	}

 /**
  * Render the dashboard page for the admin.
  */
	public function index() 
	{
		$this->data['totalUsers'] = $this->user_model->getAllFirstNames();
		$this->data['totalProducts'] = $this->Product_model->getCountOfActiveProducts();
		$this->data['totalOrders'] = $this->Order_model->getAllOrders();

		$totalSales = 0;
		foreach ($this->data['totalOrders'] as $order) {
			$totalSales += $order->total_amount;
		}

		$this->data['totalSales']        = $totalSales;
		$this->data['totalMonthlySales'] = $this->getMonthlyTotalSales();
		$this->data['totalOrdersData']   = $this->getWeeklyTotalOrdersData();

		$this->adminRenderTemplate('admin/Dashboard/dashboardPage', $this->data);
	}

	/**
     * Retrieves the total sales amount for each of the last six months.
     * 
     * This function queries the database to calculate the total sales amount 
     * for each of the last six months, returning an array containing the 
     * month and its corresponding total sales amount.
     * 
     * @return array An array containing the total sales amount for each of 
     *               the last six months, in reverse chronological order.
     */
    public function getMonthlyTotalSales()
    {
        $currentDate = date('Y-m-d');
        $result = [];

        for ($i = 0; $i < 6; $i++) {
            $monthYear = date('Y-m', strtotime("-$i months", strtotime($currentDate)));
            $sql = "SELECT SUM(total_amount) as total_amount 
                    FROM orders 
                    WHERE DATE_FORMAT(created_at, '%Y-%m') = ?
                    GROUP BY DATE_FORMAT(created_at, '%Y-%m')";

            $query = $this->db->query($sql, array($monthYear));
            $row = $query->row_array();

            $result[] = [
                'month' => $monthYear,
                'total_amount' => isset($row['total_amount']) ? $row['total_amount'] : 0
            ];
        }

        $result = array_reverse($result);

        return $result;
    }

	/**
	 * Retrieves the total number of orders for each day in the past week.
	*
	* This method calculates the total number of orders for each day in the past week
	* by querying the database for orders created within the last 7 days. It then formats
	* the data and returns an array containing the order date and the number of orders
	* for each day.
	*
	* @return array An array containing the order date and the number of orders for each day in the past week.
	*/
	public function getWeeklyTotalOrdersData() {
        $currentDate = date('Y-m-d');
		$startDate = date('Y-m-d', strtotime('-7 days', strtotime($currentDate)));
		$endDate = date('Y-m-d  23:59:59', strtotime($currentDate));
        
		$this->db->select("DATE(created_at) as order_date, COUNT(*) as num_orders");
		$this->db->where("created_at BETWEEN '$startDate' AND '$endDate'", NULL, FALSE);
		$this->db->group_by('order_date');
		$query = $this->db->get('orders');
		
		$ordersByDate = [];
		foreach ($query->result() as $order) {
			$formatted_date = date('j M', strtotime($order->order_date));
			$ordersByDate[$formatted_date] = $order->num_orders;
		}
		
        $result = [];
		$current = strtotime($startDate);
		while ($current <= strtotime($endDate)) {
			$orderDay = date('j M', $current);
			$numOrders = isset($ordersByDate[$orderDay]) ? $ordersByDate[$orderDay] : 0;
			$result[] = ['order_date' => $orderDay, 'num_orders' => $numOrders];
			$current = strtotime('+1 day', $current);
		}

        return $result;
	}

	/**
	 * Fetches order data including user information, status, and actions for display.
	* Retrieves orders data with associated user information and formats it for display.
	* 
	* @return void
	*/
	public function fetchOrderData() {
		$orders = $this->Order_model->getOrdersDataWithUser(5);

		$data = [];
		$status = $this->Order_model->getStatusData();
		foreach ($orders as $order) {
			$userName = $order->user_name;
			if(!$userName){
				$address = json_decode($order->address_info, true);
				$userName = ($address['first_name'] ?? '') .' '. ($address['last_name'] ?? '');
			}
			$data[] = [
				'id' => $order->id,
				'order_id' => '#' . $order->id,
				'user_name' => $userName,
				'total_amount' => '$' . number_format($order->total_amount, 2),
				'created_at' => date('Y-m-d h:i:s', strtotime($order->created_at)),
				'status' => $status[$order->status] ?? '',
				'action' => $this->getActionData($order->id),				
			];
		}
		echo json_encode(['data' => $data]);
	}

	/**
	* generate action button for display.
	* 
	* @return string
	*/
	public function getActionData($id) {
		return '<div class="btn-group btn-group-sm">
				<a href="javascript:void(0)" title="View Order" data-id="'.$id.'" class="btn btn-sm btn-warning tip view-info" data-url="'.base_url("admin/dashboard/order/show/$id").'" data-title="Order Details">
					<i class="fa fa-eye"></i>
				</a>
			</div>';
	}

	/**
	 * Display the order details for the given order ID.
	*
	* This method retrieves order details, status data, order data with items and options,
	* and user data based on the provided order ID. It then loads the view 'admin/Orders/view'
	* with the collected data and returns the HTML content.
	*
	* @param int $id The ID of the order to display
	* @return void
	*/
	public function showOrder($id) {
		$orderData = $this->Order_model->getDetails($id);
		$data['status'] = $this->Order_model->getStatusData();
		$data['orderData'] = $this->Order_model->getOrderWithItemsAndOptions($id);
		$userData = [];
		if(isset($orderData['user_id']) && $orderData['user_id']){
			$userData = $this->user_model->getUserData($orderData['user_id']);
		}
		$data['userData'] = $userData;
        $html = $this->load->view('admin/Orders/view', $data, true);
        echo $html;
	}
}
