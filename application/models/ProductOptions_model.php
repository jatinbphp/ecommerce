<?php 

class ProductOptions_model extends CI_Model
{   
    public $table = "products_options";

	public function __construct(){
		parent::__construct();
	}

	public function getDetails($optionId = null, $productId = null) {
        if($productId) {
            $sql = "SELECT * FROM $this->table WHERE product_id = ? AND id = ?";
            $query = $this->db->query($sql, [$productId, $optionId]);
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

    public function edit($data = [], $id = null, $productId = null){
        $this->db->where('id', $id)->where('product_id', $productId);
        $update = $this->db->update($this->table, $data);
        return ($update == true) ? true : false;    
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $delete = $this->db->delete($this->table);
        return ($delete == true) ? true : false;
    }

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
}
