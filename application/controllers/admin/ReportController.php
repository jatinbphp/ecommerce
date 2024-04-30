<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ReportController class extends MY_Controller.
 * This controller is responsible for handling report-related functionalities.
 */
class ReportController extends MY_Controller
{
	protected $_data = [];

	/**
	 * Constructor for the ReportController class.
	* Initializes the parent constructor.
	* Checks if the admin is logged in.
	* Sets the page title to 'User Orders Report'.
	* Loads the 'user_model and Order_model'.
	*/
	public function __construct(){
		parent::__construct();
		$this->checkAdminLoggedIn();
		$this->data['order_page_title'] = "User Orders Report";
		$this->data['sales_page_title'] = "Sales Report";
		$this->load->model('Order_model');
        $this->load->model('User_model');
	}

	/**
	 * The indexUsersOrders function renders the admin template for displaying users orders data with the provided data.
	 */
    public function indexUserOrders()
    {
		$this->data['type']="user";
        $this->data['userFirstNames'] = $this->User_model->getAllFirstNames();
        $this->adminRenderTemplate('admin/Report/userReport', $this->data);
    }

	/**
	 * The fetchUserReport function retrieves users report data and formats it for display in a DataTable.
	 */
	public function fetchUserReport()
	{
		$userId = $this->input->post('user_id'); 
		$status = $this->input->post('status');
		$daterange = $this->input->post('daterange');

		if (!empty($daterange)) {
			$dates = explode(' - ', $daterange);
			$startDate = date('Y-m-d', strtotime($dates[0]));
			$endDate = date('Y-m-d', strtotime($dates[1]));
		}
	
		$data = [];
		$allData = $this->Order_model->getUserReportDetails();
	    
		if (!empty($userId) && !empty($status) && !empty($daterange)) {
			$filteredData = array_filter($allData, function($row) use ($userId, $status, $startDate, $endDate) {
				return $row->id == $userId && $row->status == $status && $row->created_date >= $startDate && $row->created_date <= $endDate;
			});
		} 
		elseif (!empty($userId) && !empty($status)) {
			$filteredData = array_filter($allData, function($row) use ($userId, $status) {
				return $row->id == $userId && $row->status == $status;
			});
		} 
		elseif (!empty($userId) && !empty($daterange)) {
			$filteredData = array_filter($allData, function($row) use ($userId, $startDate, $endDate) {
				return $row->id == $userId && $row->created_date >= $startDate && $row->created_date <= $endDate;
			});
		}
		elseif (!empty($status) && !empty($daterange)) {
			$filteredData = array_filter($allData, function($row) use ($status, $startDate, $endDate) {
				return $row->status == $status && $row->created_date >= $startDate && $row->created_date <= $endDate;
			});
		}
		elseif (!empty($userId)) {
			$filteredData = array_filter($allData, function($row) use ($userId) {
				return $row->id == $userId;
			});
		} 
		elseif (!empty($status)) {
			$filteredData = array_filter($allData, function($row) use ($status) {
				return $row->status == $status;
			});
		} 
		elseif (!empty($daterange)) {
			$filteredData = array_filter($allData, function($row) use ($startDate, $endDate) {
				return $row->created_date >= $startDate && $row->created_date <= $endDate;
			});
		}
		else {
			$filteredData = $allData;
		}
	
		$groupedData = [];
		foreach ($filteredData as $row) {
			$userId = $row->id;
			if (!isset($groupedData[$userId])) {
				$groupedData[$userId] = [
					'first_name' => $row->first_name,
					'email' => $row->email,
					'total_orders' => 0,
					'total_amount' => 0,
					'total_products_ordered' => 0,
				];
			}
			$groupedData[$userId]['total_orders']++;
			$groupedData[$userId]['total_amount'] += $row->total_amount;
			$groupedData[$userId]['total_products_ordered'] += $row->total_products_ordered;
		}
		foreach ($groupedData as $userId => $userData) {
			$orderReportData = [];
			$orderReportData[] = $userData['first_name'];
			$orderReportData[] = $userData['email'];
			$orderReportData[] = $userData['total_orders'];
			$orderReportData[] = $userData['total_products_ordered'];
			$orderReportData[] = '$' . number_format($userData['total_amount'],2);
			$data[] = $orderReportData;
		}
	
		$recordsTotal = count($allData);
		$recordsFiltered = count($groupedData);
		$output = [
			"draw"            => intval($_POST["draw"]),
			"recordsTotal"    => $recordsTotal,
			"recordsFiltered" => $recordsFiltered,
			"data"            => $data,
		];
		echo json_encode($output);
	}
	
	/**
	 * The indexSalesOrders function renders the admin template for displaying sales order data with the provided data.
	 */
    public function indexSalesOrders()
    {
		$this->data['type']="sales";
        $this->adminRenderTemplate('admin/Report/salesReport',$this->data );
    }

	/**
	 * The fetchSalesReport function retrieves sales report data and formats it for display in a DataTable.
	 */
    public function fetchSalesReport()
	{
		$data = [];
		$allData = $this->Order_model->getSalesReportDetails();
		$status = $this->input->post('status');
		$daterange = $this->input->post('daterange');

		if (!empty($daterange)) {
			$dates = explode(' - ', $daterange);
			$startDate = date('Y-m-d', strtotime($dates[0]));
			$endDate = date('Y-m-d', strtotime($dates[1]));
		}

		if (!empty($status) && !empty($daterange)) {
			$filteredData = array_filter($allData, function ($row) use ($status, $startDate, $endDate) {
				return $row->status == $status && $row->order_date >= $startDate && $row->order_date <= $endDate;
			});
		} elseif (!empty($status)) {
			$filteredData = array_filter($allData, function ($row) use ($status) {
				return $row->status == $status;
			});
		} elseif (!empty($daterange)) {
			$filteredData = array_filter($allData, function ($row) use ($startDate, $endDate) {
				return $row->order_date >= $startDate && $row->order_date <= $endDate;
			});
		} else {
			$filteredData = $allData;
		}

		$groupedData = [];
		foreach ($filteredData as $row) {
			$orderDate = $row->order_date;
			if (!isset($groupedData[$orderDate])) {
				$groupedData[$orderDate] = [
					'total_orders' => 0,
					'total_amount' => 0,
					'total_products_ordered' => 0,
				];
			}
			$groupedData[$orderDate]['total_orders'] += 1;
			$groupedData[$orderDate]['total_amount'] += $row->total_amount;
			$groupedData[$orderDate]['total_products_ordered'] += $row->total_products_ordered;
		}

		foreach ($groupedData as $orderDate => $salesData) {
			$orderSalesData = [];
			$orderSalesData[] = $orderDate;
			$orderSalesData[] = $salesData['total_orders'];
			$orderSalesData[] = $salesData['total_products_ordered'];
			$orderSalesData[] = '$' . number_format($salesData['total_amount'], 2);
			$data[] = $orderSalesData;
		}

		$recordsTotal = count($allData);
		$recordsFiltered = count($groupedData);

		$output = [
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $recordsFiltered,
			"data" => $data,
		];
		echo json_encode($output);
	}
}
