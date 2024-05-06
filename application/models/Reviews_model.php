<?php 

/**
 * Reviews_model Class
 *
 * This class serves as the model for handling reviews in the CodeIgniter application.
 * It extends the CI_Model class provided by CodeIgniter, which gives it access to various
 * database manipulation methods.
 */
class Reviews_model extends CI_Model
{   
    public $table = "reviews";
	public $order_column = ['full_name', 'description'];
	public $select_column = ['*'];

 /**
  * Constructor for the class.
  *
  * Calls the constructor of the parent class.
  */
	public function __construct(){
		parent::__construct();
	}

 /**
  * Retrieves details from the database based on the provided product ID.
  *
  * If the product ID is not provided or is 0, an empty array is returned.
  *
  * @param int $productId The ID of the product to retrieve details for.
  * @return array An array containing the details of the product based on the provided product ID.
  */
	public function getDetailsBasedOnProductId($productId = 0) {
		if(!$productId) {
            return [];
        }

		$sql = "SELECT * FROM $this->table where product_id = $productId ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

 /**
  * Create a new record in the database table with the given data.
  *
  * @param array $data
  * @return int The ID of the newly created record, or 0 if creation fails or no data is provided.
  */
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

 /**
  * Constructs a query based on the provided ID and search parameters.
  *
  * @param int $id The ID to search for
  */
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

    /**
     * Retrieves product-wise review data from the database.
     *
     * This method selects the product ID, total rating count, average rating count, and total number of reviews
     * for each product from the database table. It groups the data by product ID and returns an array
     * containing the product-wise review data.
     *
     * @return array
     */
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
