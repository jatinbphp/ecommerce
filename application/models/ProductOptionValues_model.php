<?php 

/**
 * This class represents the Product Option Values model.
 * It is used to interact with the database and perform CRUD operations related to product option values.
 */
class ProductOptionValues_model extends CI_Model
{   
    public $table = "products_options_values";

	public function __construct(){
		parent::__construct();
	}

	public function getDetails($optionValueId = null, $optionId = null, $productId = null) {
        if($productId && $optionValueId && $optionId) {
            $sql = "SELECT * FROM $this->table WHERE option_id = ? AND product_id = ? AND id = ?";
            $query = $this->db->query($sql, [$optionId, $productId, $optionValueId]);
            return $query->row_array();
        }

        $sql = "SELECT * FROM $this->table ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getOptionValue($optionValueId = null) {
        if(!$optionValueId){
            return [];
        }
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        return $this->db->query($sql, [$optionValueId])->row_array();
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
     * Edit a record in the database table based on the provided parameters.
     *
     * @param array $data
     * @param int|null $optionValueId
     * @param int|null $optionId
     * @param int|null $productId
     * @return bool
     */
    public function edit($data = [], $optionValueId = null, $optionId = null, $productId = null){
        $this->db->where('id', $optionValueId)->where('product_id', $productId)->where('option_id', $optionId);
        $update = $this->db->update($this->table, $data);
        return ($update == true) ? true : false;    
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
     * Delete product options values from the database for a given product ID.
     *
     * @param int $productId The ID of the product whose options values need to be deleted.
     * @return bool True if deletion was successful, false otherwise.
     */
    public function deleteProductOptionsValues($productId) {
        $this->db->where('product_id', $productId);
        $this->db->delete($this->table);
        
        return $this->db->affected_rows() > 0;
    }


    public function filterProductOptions($option_ids = []){
        $this->db->select('MIN(products_options_values.id) AS id, option_value,  COUNT(*) AS product_count');
        $this->db->from($this->table);
        $this->db->join('products', 'products_options_values.product_id = products.id', 'left');
        $this->db->where('products.status', 'active');
        $this->db->group_by('option_value');

        if(!empty($option_ids)){
            $this->db->where_in('products_options_values.option_id', $option_ids);
        }

        $query = $this->db->get();

        return $query->result_array();
    }
}
