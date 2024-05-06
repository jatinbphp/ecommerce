<?php
/**
 * This class represents the Order Options Model in the CodeIgniter framework.
 * It is responsible for handling database operations related to order options.
 */
class Order_options_model extends CI_Model
{   
    public $table = "order_options";

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
     * @param array $data The data to be inserted into the table
     * @return int The ID of the newly created record, or 0 if creation fails or no data is provided
     */
    public function create($data = []){
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
     * Get the order items options by order ID and product ID from the database.
     *
     * @param int $orderId The ID of the order
     * @param int $productId The ID of the product
     * @return array An array of order items options matching the given order ID and product ID
     */
    public function getOrderItemsOptionsByOrderIdAndProductId($orderId, $productId) {
        $this->db->where('order_id', $orderId);
        $this->db->where('order_product_id', $productId);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }
}