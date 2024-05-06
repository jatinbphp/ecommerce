<?php 

/**
 * This class represents the Subscription Plan model in the CodeIgniter application.
 * It is responsible for handling database operations related to subscription plans.
 */
class SubscriptionPlan_model extends CI_Model
{   
    public $table = "subscription_plans";
    public $select_column = ['*'];
    public $order_column = ['id', 'name', 'duration', 'description', 'status', 'created_at'];

    /**
     * Constructor for the class.
    * Calls the constructor of the parent class.
    */
	public function __construct(){
		parent::__construct();
	}

    /**
     * Class representing status constants and their corresponding text values.
     */
    const STATUS_ACTIVE        = 'active';
    const STATUS_INACTIVE      = 'inactive';
    const STATUS_ACTIVE_TEXT   = "Active";
    const STATUS_INACTIVE_TEXT = "In Active";

    public static $status = [
        self::STATUS_ACTIVE   => self::STATUS_ACTIVE_TEXT,
        self::STATUS_INACTIVE => self::STATUS_INACTIVE_TEXT,
    ];

    /**
     * Class representing different durations with their corresponding values.
     */
    const DURATION_1_MONTH   = '1';
    const DURATION_3_MONTHS  = '3';
    const DURATION_6_MONTHS  = '6';
    const DURATION_12_MONTHS = '12';

    public static $duration = [
        ''                       => '-Select Duration-',
        self::DURATION_1_MONTH   => '1 Month',
        self::DURATION_3_MONTHS  => '3 Months',
        self::DURATION_6_MONTHS  => '6 Months',
        self::DURATION_12_MONTHS => '12 Months',
    ];

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
     * Edit a record in the database table with the provided data and ID.
     *
     * @param array $data The data to update in the record.
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
     * @param int $id The ID of the record to be deleted
     * @return bool True if the record was successfully deleted, false otherwise
     */
    public function delete($id){
        $this->db->where('id', $id);
        $delete = $this->db->delete($this->table);
        return ($delete == true) ? true : false;
    }

    /**
     * Generates a DataTables response by querying the database based on the DataTables request parameters.
     *
     * This method constructs and executes a query based on the DataTables request parameters such as length, start, and search value.
     *
     * @return array The result set of the query.
     */
    public function make_datatables(){
        $this->make_query();
        
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        if ($_POST["search"]["value"]!='') {
            $searchString = $_POST["search"]["value"];
            $this->db->where("(id LIKE '%".$searchString."%' OR name LIKE '%".$searchString."%' OR duration LIKE '%".$searchString."%' OR description LIKE '%".$searchString."%' OR status LIKE '%".$searchString."%')", NULL, FALSE);
        }

        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Constructs a query based on the provided parameters for data retrieval.
     * Selects specific columns, sets the table, applies search criteria, and orders the results.
     */
    public function make_query(){
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        if ($_POST["search"]["value"]!='') {
            $searchString = $_POST["search"]["value"];
        }

        if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
            $this->db->order_by($this->order_column[$_POST['order'][0]['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'DESC');
        }        
    }

    /**
     * Retrieves and returns the number of rows from the filtered data based on the constructed query.
     *
     * @return int The number of rows in the result set
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

    /**
     * Get details from the database based on the provided ID or return all details if ID is not specified.
     *
     * @param int|null $id
     * @return array
     */
    public function getDetails($id = null) {
        if($id) {
            $sql = "SELECT * FROM $this->table WHERE id = ?";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT * FROM $this->table ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
