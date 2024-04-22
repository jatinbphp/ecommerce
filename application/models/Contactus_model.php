<?php 

/**
 * Contactus_model Class
 *
 * This class serves as the model for handling contact us related data.
 */
class Contactus_model extends CI_Model
{   
    public $table = "contact_us";
    public $select_column = ['*'];
    public $order_column = ['id', 'name', 'email', 'message', 'created_at'];

	public function __construct(){
		parent::__construct();
	}

    /**
     * Get the details of a specific banner if $bannerId is provided, otherwise, get all banners' details.
    *
    * @param int|null $bannerId
    * @return array
    */
	public function getDetails($bannerId = null) {
		if($bannerId) {
			$sql = "SELECT * FROM $this->table WHERE id = ?";
			$query = $this->db->query($sql, array($bannerId));
			return $query->row_array();
		}

		$sql = "SELECT * FROM $this->table ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    /**
     * Create a new record in the database table with the given data.
    *
    * @param mixed $data The data to be inserted into the table.
    * @return bool True if the record was successfully created, false otherwise.
    */
	public function create($data = ''){
		if($data) {
			$create = $this->db->insert($this->table, $data);
			return ($create == true) ? true : false;
		}
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
     * Constructs and prepares a query based on the provided search and order parameters.
    * 
    * This method constructs a query using the specified select column and table, and applies search and order conditions based on the POST data received.
    * 
    * @return void
    */
	public function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        if ($_POST["search"]["value"]!='') {
            $searchString = $_POST["search"]["value"];
            $this->db->where("(name LIKE '%".$searchString."%' OR email LIKE '%".$searchString."%' OR id LIKE '%".$searchString."%' OR message LIKE '%".$searchString."%')", NULL, FALSE);
        }

        if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
            $this->db->order_by($this->order_column[$_POST['order'][0]['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'DESC');
        }        
    }

    /**
     * Generate data for DataTables.
     *
     * This method prepares and executes a query based on the DataTables request parameters.
     * It limits the number of results based on the length and start parameters from the request.
     *
     * @return array The result data for DataTables.
     */
    public function make_datatables()
    {
        $this->make_query();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Retrieves and returns the number of rows from the filtered data based on the query.
     *
     * @return int The number of rows in the filtered data
     */
    public function get_filtered_data()
    {
        $this->make_query();
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
}