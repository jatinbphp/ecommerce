<?php 

/**
 * This class represents the Product Image model in the CodeIgniter framework.
 * It is responsible for handling database operations related to product images.
 */
class ProductImage_model extends CI_Model
{   
    public $table = "product_images";

	public function __construct(){
		parent::__construct();
	}

 /**
  * Get the details of a product by product ID or return all products if no ID is provided.
  *
  * @param int|null $productId
  * @return array
  */
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

    /**
     * Create a new record in the database table with the provided data.
     *
     * @param mixed $data The data to be inserted into the table
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
     * Delete a record from the database based on the given ID.
     *
     * @param int $id The ID of the record to delete
     * @return bool True if the record was successfully deleted, false otherwise
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $delete = $this->db->delete($this->table);
        return ($delete == true) ? true : false;
    }
    
    /**
     * Delete product images associated with the given product ID from the database and file system.
     *
     * @param int $productId
     * @return bool True if images were successfully deleted, false otherwise
     */
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
