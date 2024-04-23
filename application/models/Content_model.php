<?php 
/**
 * Content_model Class
 *
 * This class serves as the model for handling content-related database operations.
 */
class Content_model extends CI_Model
{   
    public $table = "content_management";
    public $select_column = ['*'];
    public $order_column = ['id', 'title', 'description'];

	public function __construct(){
		parent::__construct();
	}

    /**
     * Get the details of the content based on the content ID if provided, otherwise return all content details.
    *
    * @param int|null $contentId
    * @return array
    */
	public function getDetails($contentId = null) {
		if($contentId) {
			$sql = "SELECT * FROM $this->table WHERE id = ?";
			$query = $this->db->query($sql, [$contentId]);
			return $query->row_array();
		}

		$sql = "SELECT * FROM $this->table ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

 /**
  * Create a new record in the database table with the provided data.
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
     * Edit a record in the database table with the provided data and ID.
    *
    * @param array $data The data to be updated in the record.
    * @param int|null $id The ID of the record to be updated.
    * @return bool Returns true if the record was successfully updated, false otherwise.
    */
	public function edit($data = array(), $id = null){
		$this->db->where('id', $id);
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
     * Constructs and executes a query based on the provided search and order parameters.
     * 
     * This method builds a query using the specified select column, table, search criteria, and order criteria.
     * If a search value is provided, it filters the results based on the search string matching the name, status, or id columns.
     * If order information is provided, it orders the results based on the specified column and direction.
     */
    public function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        if ($_POST["search"]["value"]!='') {
            $searchString = $_POST["search"]["value"];
            $this->db->where("(name LIKE '%".$searchString."%' OR status LIKE '%".$searchString."%' OR id LIKE '%".$searchString."%')", NULL, FALSE);
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
     * This method prepares the query for DataTables and returns the result set.
     *
     * @return array
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
     * @return int
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
