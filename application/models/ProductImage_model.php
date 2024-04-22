<?php 

class ProductImage_model extends CI_Model
{   
    public $table = "product_images";

	public function __construct(){
		parent::__construct();
	}

	public function getDetails($productId = null) {
        if($productId) {
            $sql = "SELECT * FROM $this->table WHERE product_id = ?";
            $query = $this->db->query($sql, array($productId));
            return $query->result_array(); // Return multiple records
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

    public function delete($id)
    {
        $this->db->where('id', $id);
        $delete = $this->db->delete($this->table);
        return ($delete == true) ? true : false;
    }

    public function getImagesByProductId($product_id) {
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('product_images');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }
}
