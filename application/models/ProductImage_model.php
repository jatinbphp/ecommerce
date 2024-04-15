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

    public function deleteProductImages($productId) {

        $this->db->select('image');
        $this->db->where('product_id', $productId);
        $query = $this->db->get($this->table);
        $images = $query->result_array();

        $this->db->where('product_id', $productId);
        $this->db->delete($this->table);

        foreach ($images as $image) {
            $imagePath = $image['image'];
            if (!empty($imagePath) && file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        return $this->db->affected_rows() > 0;
    }
}
