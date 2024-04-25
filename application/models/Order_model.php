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
}