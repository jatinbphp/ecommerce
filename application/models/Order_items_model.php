<?php
/**
 * Order_items_model class represents the model for managing order items in CodeIgniter.
 */
class Order_items_model extends CI_Model
{   
    public $table = "order_items";
    public $order_column = ['id', 'order_id', 'product_id', 'product_name', 'product_sku', 'product_price', 'product_qty', 'sub_total','created_at'];

    /**
     * Constructor for the class.
     * Calls the parent class constructor.
     */
    public function __construct(){
	    parent::__construct();
	}

    /**
     * Create a new record in the database table with the provided data.
     *
     * @param string|array $data The data to be inserted into the table
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
     * Get the order items from the database based on the order ID.
     *
     * @param int $orderId The ID of the order to retrieve items for
     * @return array An array of order items associated with the given order ID
     */
    public function getOrderItemsByOrderId($orderId) {
        $this->db->where('order_id', $orderId);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    /**
     * Get the order items from the database based on the order ID.
     *
     * @param int $orderId The ID of the order
     * @return array An array of order items associated with the given order ID
     */
    public function getOrderItemsByOrderIdArray($orderId) {
        $this->db->where('order_id', $orderId);
        $query = $this->db->get($this->table);
		return $query->result_array();
    }
}