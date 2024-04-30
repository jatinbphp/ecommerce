<?php 

class Reviews_model extends CI_Model
{   
    public $table = "reviews";
	public $order_column = ['full_name', 'description'];
	public $select_column = ['*'];

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

	public function make_query($id)
    {
        $this->db->select($this->select_column);
		$this->db->where('product_id', $id);
        $this->db->order_by('created_at', 'desc');
        $this->db->from($this->table);

        if ($_POST["search"]["value"]!='') {
            $searchString = $_POST["search"]["value"];
            $this->db->where("(full_name LIKE '%".$searchString."%' OR description LIKE '%".$searchString."%')", NULL, FALSE);
        }

        if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
            $this->db->order_by($this->order_column[$_POST['order'][0]['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'DESC');
        }        
    }

    /**
     * Generate data for DataTables.
     * Executes a query based on DataTables parameters and returns the result set.
     *
     * @return array Result set for DataTables
     */
    public function make_datatables($id)
    {
        $this->make_query($id);
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Retrieves and returns the number of rows from the filtered data based on the constructed query.
     *
     * @return int The number of rows in the result set
     */
    public function get_filtered_data($id)
    {
        $this->make_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Retrieves all data from the specified table.
     *
     * @return int The total count of rows in the table.
     */
    public function get_all_data()
    {
        $this->db->select("*");
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function getProductWiseReviewData(){
        $this->db->select('product_id, SUM(rating) as total_rating_count, AVG(rating) as avg_rating_count, count(id) as total_reviews');
        $this->db->from($this->table);
        $this->db->group_by('product_id');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $productWiseReviewData = [];
            foreach($query->result_array() as $data){
                $productId = $data['product_id'] ?? '';
                if(!$productId){
                    continue;
                }
                $productWiseReviewData[$productId] = $data;
            }
            return $productWiseReviewData;
        }

        return [];
    }

}
