<?php
/**
 * Order_model class represents the model for handling orders in the CodeIgniter application.
 */
class Order_model extends CI_Model
{   
    public $table = "orders";
    public $select_column = '*';
    public $order_column = ['id','user_id','address_id', 'total_amount', 'status', 'delivey_method', 'notes', 'address_info','created_at'];

    /**
     * Constructor for the class.
     *
     * Calls the parent class constructor.
     */
    public function __construct(){
        $this->load->model('Product_model');
        $this->load->model('Order_items_model');
        $this->load->model('Order_options_model');
        $this->load->model('user_model');
        $this->load->model('Cart_model');
        $this->load->model('Settings_model');
	    parent::__construct();
	}

    /**
     * Create a new record in the database table with the provided data.
     *
     * @param mixed $data The data to be inserted into the table
     * @return int The ID of the newly created record, or 0 if creation fails or no data is provided
     */
    public function create($data = ''){
		if($data) {
            $create = $this->db->insert($this->table, $data);
            if ($create) {
                return $this->db->insert_id();
            } else {
                return 0;
            }
        }
        return 0;
	}

    /**
     * Edit a record in the database table with the provided data and ID.
     *
     * @param array $data The data to be updated in the record.
     * @param int|null $id The ID of the record to be updated.
     * @return bool Returns true if the record was successfully updated, false otherwise.
     */
    public function edit($data = array(), $id = null){
		$this->db->where('id', $id);
		$update = $this->db->update($this->table, $data);
		return ($update == true) ? true : false;	
	}
    
    /**
     * Generates a DataTables response by executing the query and applying limit and start parameters.
     *
     * @return array The result of the query for DataTables
     */
    public function make_datatables()
    {
        $this->make_query();
        $limit = isset($_POST["length"]) ? $_POST["length"] : -1;
        $start = isset($_POST["start"]) ? $_POST["start"] : 0;
    
        if ($limit != -1) {
            $this->db->limit($limit, $start);
        }
    
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get the number of rows returned after filtering the data based on the query.
     *
     * @return int
     */
    public function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Retrieves all data from the specified table.
     *
     * @return int The total count of rows in the table.
     */
    public function get_all_data()
    {
        $this->db->select("*");
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    /**
     * Constructs a query using the specified columns and conditions.
     * The query selects specific columns, specifies the table, and adds a condition based on the user ID.
     * It also includes an optional ordering based on the provided POST data.
     */
    public function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->where('user_id', $this->session->userdata('userId'));
        
        if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
            $this->db->order_by($this->order_column[$_POST['order'][0]['column']], $_POST['order'][0]['dir']);
        } else {
            $this->db->order_by('id', 'DESC');
        }
    }

    /**
     * Get the order details from the database based on the order ID.
     *
     * @param int $orderId The ID of the order to retrieve.
     * @return mixed The order details as an object.
     */
    public function getOrderById($orderId)
    {
        return $this->db->get_where('orders', ['id' => $orderId])->row();
    }

    /**
     * Retrieve user report 
     * This function fetches details of order report details including their first name, email, user ID, along with 
     * details of their orders such as order ID, order status, order creation date, total orders, total amount,
     * total products ordered, and status. It allows sorting by specified columns and searching for users based 
     * on first name or email.
     *
     * @return array The array of user report details 
     */
    public function getUserReportDetails()
    {
        if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
            $this->db->order_by($this->order_column[$_POST['order'][0]['column']], $_POST['order'][0]['dir']);
        } else {
            $this->db->order_by('id', 'DESC');
        }

        if (isset($_POST['search']['value']) && $_POST['search']['value'] != '') {
            $search_value = $_POST['search']['value'];
            $this->db->group_start();
            $this->db->like('users.first_name', $search_value);
            $this->db->or_like('users.email', $search_value);
            $this->db->group_end();
        }

        $this->db->select('users.first_name, users.email, users.id, 
                        orders.id AS order_id,
                        orders.status AS order_status,
                        orders.created_at AS order_created_date,
                        COUNT(DISTINCT orders.id) AS total_orders, 
                        orders.total_amount AS total_amount,
                        COUNT(order_items.product_id) AS total_products_ordered, 
                        MAX(orders.status) AS status, 
                        DATE(MAX(orders.created_at)) AS created_date');
        $this->db->from($this->table);
        $this->db->join('users', 'users.id = orders.user_id');
        $this->db->join('order_items', 'order_items.order_id = orders.id');

        $this->db->group_by('users.id, orders.id,users.email');

        $query = $this->db->get();
        return $query->result(); 
    }

    /**
     * Retrieve sales report grouped by date.
     * This function fetches sales report details such as order date, order ID, total orders, total amount,
     * total products ordered, and status, grouped by the date of creation.
     * Additionally, it allows sorting by specified columns and searching for orders based on a search value.
     *
     * @return array The array of sales report grouped by date.
     */
    public function getSalesReportDetails()
    {
        if (isset($_POST['order']) && !empty($_POST['order'])) {
            $order_column = $_POST['order'][0]['column'];
            $order_dir = $_POST['order'][0]['dir'];
            $columns = array('order_date', 'order_id', 'total_orders', 'total_amount', 'total_products_ordered', 'status');
            if (isset($columns[$order_column])) {
                $this->db->order_by($columns[$order_column], $order_dir);
            }
        }

        if (isset($_POST['search']['value']) && $_POST['search']['value'] != '') {
            $search_value = $_POST['search']['value'];
            $this->db->group_start();
            $this->db->like('orders.created_at', $search_value);
            $this->db->group_end();
        }
        
        $this->db->select('DATE(orders.created_at) AS order_date, orders.id AS order_id, COUNT(orders.id) AS total_orders, orders.total_amount AS total_amount, COUNT(order_items.product_id) AS total_products_ordered, MAX(orders.status) AS status');
        $this->db->from($this->table);
        $this->db->join('order_items', 'order_items.order_id = orders.id');
        $this->db->group_by('DATE(orders.created_at), orders.id'); 
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Class containing constants for status values and their corresponding text representations.
    */
    const STATUS_TYPE_PENDING  = 'pending';
    const STATUS_TYPE_REJECT   = 'reject';
    const STATUS_TYPE_COMPLETE = 'complete';
    const STATUS_TYPE_CANCEL   = 'cancel';
    
    public static $allStatus = [
        self::STATUS_TYPE_PENDING => 'Pending',
        //self::STATUS_TYPE_REJECT => 'Reject',
        self::STATUS_TYPE_COMPLETE => 'Complete',
        self::STATUS_TYPE_CANCEL => 'Cancel',
    ];
    
    /**
     * Retrieve orders data along with user information from the database.
     *
     * @param int $limit The maximum number of records to retrieve (default is 1).
     * @return array An array of orders data with user information.
     */
    public function getOrdersDataWithUser($limit=1)
    {
        return $this->db
            ->select('orders.*, CONCAT(users.first_name, " ", users.last_name, " (", users.email, ")") AS user_name')
            ->from($this->table)
            ->join('users', 'orders.user_id = users.id', 'left')
            ->order_by('orders.id', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    /**
     * Get the details of the order with the specified order ID, or all orders if no order ID is provided.
     *
     * @param int|null $orderId
     * @return array
     */
    public function getDetails($orderId = null) {
		if($orderId) {
			$sql = "SELECT * FROM $this->table WHERE id = ?";
			$query = $this->db->query($sql, array($orderId));
			return $query->row_array();
		}

		$sql = "SELECT * FROM $this->table ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    /**
     * Retrieve all orders from the database table.
     *
     * @return array An array of all orders retrieved from the database.
     */
    public function getAllOrders(){
        $sql = "SELECT * FROM $this->table ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result();
    }

    /**
	 * Get the status data with corresponding HTML badge elements.
	*
	* @return array
	*/
	public function getStatusData(){
		return [
			'pending' => '<span class="badge badge-primary">Pending</span>',
			'reject'  => '<span class="badge badge-warning">Reject</span>',
			'complete'=> '<span class="badge badge-success">Complete</span>',
			'cancel'  => '<span class="badge badge-danger">Cancel</span>',
		]; 
	}

    /**
	 * Retrieve order details along with items and options based on the provided order ID.
	*
	* @param int $id The ID of the order
	* @return array An array containing order details, items, and options
	*/
	public function getOrderWithItemsAndOptions($id)
	{
		$order = $this->Order_model->getDetails($id);
		$orderItems = $this->Order_items_model->getOrderItemsByOrderIdArray($id);

		foreach ($orderItems as &$item) {
			$product_id = $item['product_id'];
			$orderItemId = $item['id'];
			$product = $this->Product_model->getDetails($product_id);

			$product_image =  current($this->ProductImage_model->getDetails($product_id));
			$product['image'] = $product_image['image'] ?? '';

			$item['product'] = $product;
			$item['options'] = $this->Order_options_model->getOrderItemsOptionsByOrderIdAndProductId($id, $orderItemId);
		}
		$order['items'] = $orderItems;
		return $order;
	}

     /**
     * Generates a DataTables response by executing the query and applying limit and start parameters.
     *
     * @return array The result of the query for DataTables
     */
    public function make_order_datatables()
    {
        $this->make_order_query();
        $limit = isset($_POST["length"]) ? $_POST["length"] : -1;
        $start = isset($_POST["start"]) ? $_POST["start"] : 0;
    
        if ($limit != -1) {
            $this->db->limit($limit, $start);
        }
    
        $query = $this->db->get();
        return $query->result();
    }
    
    public function make_order_query()
    {
        $this->db->select('orders.*,CASE 
        WHEN users.id IS NOT NULL THEN CONCAT(users.first_name, " ", users.last_name, " (", users.email, ")")
        ELSE CONCAT(
            JSON_UNQUOTE(JSON_EXTRACT(address_info, "$.first_name")), 
            " ", 
            JSON_UNQUOTE(JSON_EXTRACT(address_info, "$.last_name")), 
            IF(JSON_EXTRACT(address_info, "$.email") IS NOT NULL, CONCAT(" (", JSON_UNQUOTE(JSON_EXTRACT(address_info, "$.email")), ")"), "")
        )
        END AS user_name', FALSE)
            ->from($this->table)
            ->join('users', 'orders.user_id = users.id', 'left');
        
        if ($_POST["search"]["value"]!='') {
            $searchString = $_POST["search"]["value"];
            $this->db->where("(CASE 
            WHEN users.id IS NOT NULL THEN CONCAT(users.first_name, ' ', users.last_name, ' (', users.email, ')')
            ELSE CONCAT(JSON_UNQUOTE(JSON_EXTRACT(address_info, '$.first_name')), ' ', JSON_UNQUOTE(JSON_EXTRACT(address_info, '$.last_name')), 
                IF(JSON_EXTRACT(address_info, '$.email') IS NOT NULL, CONCAT(' (', JSON_UNQUOTE(JSON_EXTRACT(address_info, '$.email')), ')'), '')
            )
            END LIKE '%".$searchString."%' OR orders.status LIKE '%".$searchString."%' OR orders.id LIKE '%".$searchString."%' OR orders.total_amount LIKE '%".$searchString."%')", NULL, FALSE);

        }

        if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
            $this->db->order_by($this->order_column[$_POST['order'][0]['column']], $_POST['order'][0]['dir']);
        } else {
            $this->db->order_by('id', 'DESC');
        }
    }

    public function get_all_order_data() {
        $this->db->select('orders.*, CONCAT(users.first_name, " ", users.last_name, " (", users.email, ")") AS user_name')
            ->from($this->table)
            ->join('users', 'orders.user_id = users.id', 'left');

            return $this->db->count_all_results();
    }

    public function get_filtered_order_data()
    {
        $this->make_order_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getTotalAmount($isOnlyTotal = 1) {
        $userId = $this->session->userdata('userId');
        $orderProducts = $this->Cart_model->getUsrCartData($userId);
        if(!$userId){
            $cartData = $this->session->userdata('cartData') ?? '';
            $userCartData = json_decode($cartData, true) ?? [];
            $orderProducts = $this->Cart_model->getGuestUserCartData($userCartData);
        }

        if(empty($orderProducts)){
           return 0;
        }

        $orderTotal = 0;
        foreach ($orderProducts as $key => $data) {
            $productData = $data['cart_data']['productData'] ?? [];
            $productId = ($productData['product_id'] ?? 0);
            if(!$productId){
                continue;
            }
            $subTotal = (($productData['price'] ?? 0)* ($productData['quantity']));
            $orderTotal += $subTotal;
            
        }

        $settingData  = $this->Settings_model->getSettingsById(1);
        $shippingCharge = $settingData['shipping_charges'] ?? 0;

        if($shippingCharge && $orderTotal && $isOnlyTotal){
            $orderTotal += $shippingCharge;
        }

        return $orderTotal;
    }

    public function getTaxData($address, $city, $state, $pincode, $country){
        require_once('./vendor/stripe/stripe-php/init.php');
        $settingData  = $this->Settings_model->getSettingsById(1);
        $stripeSecretKey = $this->Settings_model->getStripeSecretKey();       

        $stripe = new \Stripe\StripeClient($stripeSecretKey);
        $amount = $this->getTotalAmount(0);
        try {
            $taxData = $stripe->tax->calculations->create([
                'currency' => 'usd',
                'line_items' => [
                    [
                        'amount' => $amount,
                        'reference' => 'L1',
                    ],
                ],
                'customer_details' => [
                    'address' => [
                        'line1' => $address,
                        'city' => $city,
                        'state' => $state,
                        'postal_code' => $pincode,
                        'country' => $country,
                    ],
                    'address_source' => 'shipping',
                ],
            ]);

            $taxPercentage = $taxData->tax_breakdown['0']->tax_rate_details->percentage_decimal ?? 0;
            $afterTaxAmount = $taxData->amount_total ?? 0;
            $taxAmount      = $taxData->tax_amount_exclusive ?? 0;

            $data = [
                'tax_percentage'   => $taxPercentage,
                'after_tax_amount' => $afterTaxAmount,
                'tax_amount'       => $taxAmount,
            ];
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $data = [];
        }

        return $data;
    }

    public function refundAmount($intentId){
        require_once('./vendor/stripe/stripe-php/init.php');
        $settingData  = $this->Settings_model->getSettingsById(1);
        $stripeSecretKey = $this->Settings_model->getStripeSecretKey();
        \Stripe\Stripe::setApiKey($stripeSecretKey);

        try {
            $payment_intent = \Stripe\PaymentIntent::retrieve($intentId);

            if($payment_intent){
                $refund = \Stripe\Refund::create([
                    'payment_intent' => $intentId,
                    'reason' => 'requested_by_customer',
                ]);
            }
    
            $data = [
                'status'    => 1,
                'refund_id' => $refund->id,
            ];
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $data = [];
        }

        return $data;
    }

}