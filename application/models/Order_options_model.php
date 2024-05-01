<?php
class Order_options_model extends CI_Model
{   
    public $table = "order_options";

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
    
    public function getOrderItemsByOrderId($orderId) {
        $this->db->where('order_id', $orderId);
        $query = $this->db->get($this->table);
        return $query->result();
    }    
    
    public function getOrderItemsOptionsByOrderIdAndProductId($orderId, $productId) {
        $this->db->where('order_id', $orderId);
        $this->db->where('order_product_id', $productId);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }
}