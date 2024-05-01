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
	    parent::__construct();
	}

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
        self::STATUS_TYPE_REJECT => 'Reject',
        self::STATUS_TYPE_COMPLETE => 'Complete',
        self::STATUS_TYPE_CANCEL => 'Cancel',
    ];

    public function getAllOrders(){
        $sql = "SELECT * FROM $this->table ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result();
    }
}