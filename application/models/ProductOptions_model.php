<?php 

/**
 * This class represents the Product Options model in CodeIgniter.
 * It is responsible for handling database operations related to product options.
 */
class ProductOptions_model extends CI_Model
{   
    public $table = "products_options";

	public function __construct(){
		parent::__construct();
	}

    /**
     * Get details from the database based on the provided optionId and productId.
    *
    * If productId is provided, it fetches details for a specific product and option.
    * If productId is not provided, it fetches all details from the table.
    *
    * @param int|null $optionId
    * @param int|null $productId
    * @return array
    */
	public function getDetails($optionId = null, $productId = null) {
        if($productId && $optionId) {
            $sql = "SELECT * FROM $this->table WHERE product_id = ? AND id = ?";
            $query = $this->db->query($sql, [$productId, $optionId]);
            return $query->row_array();
        }

        $sql = "SELECT * FROM $this->table ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getOption($optionId = null) {
        if(!$optionId){
            return [];
        }
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        return $this->db->query($sql, [$optionId])->row_array();
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
     * Edit a record in the database table based on the provided ID and product ID.
     *
     * @param array $data The data to be updated
     * @param int|null $id The ID of the record to be updated
     * @param int|null $productId The product ID of the record to be updated
     * @return bool Returns true if the update was successful, false otherwise
     */
    public function edit($data = [], $id = null, $productId = null){
        $this->db->where('id', $id)->where('product_id', $productId);
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
     * Retrieve options with their values for a specific product.
     *
     * @param int $productId The ID of the product to retrieve options for
     * @return array An array containing the options and their values for the specified product
     */
    public function getOptionsWithValues($productId)
    {
        $options = $this->db->where('product_id', $productId)->get('products_options');
        $allOptions = $options->result_array();

        $productOptions = [];
        foreach ($allOptions as $option) {
            $productOptionId = $option['id'];
            $productOptions[$productOptionId] = $option;
            $productOptions[$productOptionId]['option_values'] = [];

            $optionsValues = $this->db->where('option_id', $productOptionId)->get('products_options_values');
            $optionsValuesData = $optionsValues->result_array();

            foreach ($optionsValuesData as $value) {
                $productOptions[$productOptionId]['option_values'][] = $value;
            }
        }

        return array_values($productOptions);
    }

    public function deleteProductOptions($productId) {
        $this->db->where('product_id', $productId);
        $this->db->delete($this->table);
        
        return $this->db->affected_rows() > 0;
    }

    public function getUniqueOptionNames(){
        $this->db->select('LOWER(option_name) AS option_name', false); 
        $this->db->from($this->table);
        $this->db->where('status', 'active'); 
        $this->db->group_by('LOWER(option_name)'); 
        $query = $this->db->get();
        $names = array_column($query->result_array(), 'option_name');
        return $names;
    }

    public function getOptionsByName($option_name){
        $this->db->select('id');
        $this->db->from($this->table);
        $this->db->where('status', 'active'); 
        $this->db->where("LOWER(option_name)", strtolower($option_name)); 
        $query = $this->db->get();
        $ids = array_column($query->result_array(), 'id');
        return $ids;
    }
}
