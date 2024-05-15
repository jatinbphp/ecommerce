<?php 

/**
 * Subscription_plan_users_model Class
 *
 * This class serves as the model for handling subscription users in the application.
 * It extends the CI_Model class provided by CodeIgniter, which gives it access to various
 * database methods for interacting with the subscription_plan_users table in the database.
 */
class Subscription_plan_users_model extends CI_Model
{   
    public $table = "subscription_plan_users";

	public function __construct(){
		parent::__construct();
	}

    /**
     * Get the details of the item with the specified emaill address, or return all items if no email address is provided.
    *
    * @param int|null $emailAddress
    * @return array
    */
	public function getDetailsByEmail($emailAddress = null) {
		if($emailAddress) {
			$sql = "SELECT * FROM $this->table WHERE email = ?";
			$query = $this->db->query($sql, array($emailAddress));
			return $query->result_array();
		}

		$sql = "SELECT * FROM $this->table ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
    
    /**
     * Get the details of the item with the specified subscription_id, or return all items if no subscription_id is provided.
    *
    * @param int|null $emailAddress
    * @return array
    */
	public function getDetailsBySubscriptionId($subscriptionId = null) {
		if($subscriptionId) {
			$sql = "SELECT * FROM $this->table WHERE subscription_id = ?";
			$query = $this->db->query($sql, array($subscriptionId));
			return $query->result_array();
		}

		$sql = "SELECT * FROM $this->table ORDER BY id DESC";
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
     * Delete a record from the database based on the given ID.
    *
    * @param int $id The ID of the record to be deleted
    * @return bool True if the record was successfully deleted, false otherwise
    */
	public function deleteByEmailAndSubscriptionId($data)
	{
        if(!$data){
            return false;
        }
        $subscription_id = $data['subscription_id'] ?? 0;
        $email = $data['email'] ?? '';
		$this->db->where('subscription_id', $subscription_id);
		$this->db->where('email', $email);
		$delete = $this->db->delete($this->table);
		return ($delete == true) ? true : false;
    }   
}
