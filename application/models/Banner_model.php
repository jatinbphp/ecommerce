<?php 

/**
 * Banner_model class represents a model in CodeIgniter framework.
 * It is used to interact with the database to perform CRUD operations related to banners.
 */
class Banner_model extends CI_Model
{   
    public $table = "banners";
    public $select_column = ['*'];
    public $order_column = ['id', 'title', 'subtitle', 'description', 'status', 'created_at'];

    /**
     * Constructor for the class.
    * Calls the constructor of the parent class.
    */
	public function __construct(){
		parent::__construct();
	}

    /**
     * Constants representing the status of an entity as active or inactive.
    * 
    * STATUS_ACTIVE: Represents the active status.
    * STATUS_INACTIVE: Represents the inactive status.
    * STATUS_ACTIVE_TEXT: Textual representation of the active status.
    * STATUS_INACTIVE_TEXT: Textual representation of the inactive status.
    */
	const STATUS_ACTIVE        = 'active';
    const STATUS_INACTIVE      = 'inactive';
    const STATUS_ACTIVE_TEXT   = "Active";
    const STATUS_INACTIVE_TEXT = "In Active";

    /**
     * Array mapping of status codes to their corresponding text values.
     *
     * @var array
     */
    public static $status = [
        self::STATUS_ACTIVE   => self::STATUS_ACTIVE_TEXT,
        self::STATUS_INACTIVE => self::STATUS_INACTIVE_TEXT,
    ];

 /**
  * Get details of a specific banner if $bannerId is provided, otherwise get details of all banners.
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
     * Constructs and returns a query based on the provided search and order parameters.
     *
     * This method constructs a query using the specified select column, table, search criteria, and order criteria.
     * If a search value is provided, it filters the results based on the search string matching certain columns.
     * If order information is provided, it orders the results based on the specified column and direction.
     */
    public function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        if ($_POST["search"]["value"]!='') {
            $searchString = $_POST["search"]["value"];
            $this->db->where("(id LIKE '%".$searchString."%' OR title LIKE '%".$searchString."%' OR subtitle LIKE '%".$searchString."%' OR description LIKE '%".$searchString."%' OR status LIKE '%".$searchString."%')", NULL, FALSE);
        }

        if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
            $this->db->order_by($this->order_column[$_POST['order'][0]['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'DESC');
        }        
    }

    /**
     * Generates a DataTables response by executing a query and applying length and start limits.
     *
     * @return array The result of the query as an array for DataTables
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
     * Retrieve all data from the specified table.
     *
     * @return int The total count of rows in the table.
     */
    public function get_all_data()
    {
    /**
     * Retrieves active data from the database table based on the status field.
     *
     * @return array An array containing the active data from the database table.
     */
        $this->db->select("*");
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    /**
     * Retrieves active data from the database table based on the status field.
     *
     * @return array An array containing the active data from the database table.
     */
    public function getActiveBammerData() {
        $sql = "SELECT * FROM $this->table where status = '" . self::STATUS_ACTIVE . "'  ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
