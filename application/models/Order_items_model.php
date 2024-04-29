<?php
class Order_items_model extends CI_Model
{   
    public $table = "order_items";
    public $order_column = ['id', 'order_id', 'product_id', 'product_name', 'product_sku', 'product_price', 'product_qty', 'sub_total','created_at'];

    public function __construct(){
	    parent::__construct();
	}
    
    public function getOrderItemsByOrderId($orderId) {
        $this->db->where('order_id', $orderId);
        $query = $this->db->get($this->table);
        return $query->result();
    }
}