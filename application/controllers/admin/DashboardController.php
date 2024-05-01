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
		$this->load->model('User_model');
		$this->load->model('Product_model');
		$this->load->model('Order_model');
		$this->checkAdminLoggedIn();
	}

 /**
  * Render the dashboard page for the admin.
  */
	public function index() 
	{
		$this->data['totalUsers'] = $this->User_model->getAllFirstNames();
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
}
