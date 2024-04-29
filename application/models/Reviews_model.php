<?php 

class Reviews_model extends CI_Model
{   
    public $table = "reviews";

	public function __construct(){
		parent::__construct();
	}

	public function getDetailsBasedOnProductId($productId = 0) {
		if(!$productId) {
            return [];
        }

		$sql = "SELECT * FROM $this->table where product_id = $productId ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

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
}
