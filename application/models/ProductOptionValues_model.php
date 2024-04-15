<?php 

class ProductOptionValues_model extends CI_Model
{   
    public $table = "products_options_values";

	public function __construct(){
		parent::__construct();
	}

	public function getDetails($optionValueId = null, $optionId = null, $productId = null) {
        if($productId) {
            $sql = "SELECT * FROM $this->table WHERE option_id = ? AND product_id = ? AND id = ?";
            $query = $this->db->query($sql, [$optionId, $productId, $optionValueId]);
            return $query->row_array();
        }

        $sql = "SELECT * FROM $this->table ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
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

    public function edit($data = [], $optionValueId = null, $optionId = null, $productId = null){
        $this->db->where('id', $optionValueId)->where('product_id', $productId)->where('option_id', $optionId);
        $update = $this->db->update($this->table, $data);
        return ($update == true) ? true : false;    
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $delete = $this->db->delete($this->table);
        return ($delete == true) ? true : false;
    }
}
