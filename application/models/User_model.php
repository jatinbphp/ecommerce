<?php
/**
 * User_model Class
 *
 * This class serves as the model for handling user-related database operations in CodeIgniter.
 */
class User_model extends CI_Model 
{
	public $table = "users";
    public $select_column = '*';
    public $order_column = ['id', 'first_name', 'first_name', 'email', 'phone', 'status', 'created_at'];

 /**
  * Check if a username exists in the specified table, excluding a specific ID if provided.
  *
  * @param string $table
  * @param string $username
  * @param string $id
  * @return string 'Yes' if the username exists, 'No' if it does not
  */
	function check_other_username($table,$username,$id='') {
		$this->db->select('*');
		$this->db->where('username', $username);
		if($id != '')
			$this->db->where('id != ', $id);
		$query = $this->db->get($table);
		$data = $query->row_array();
		if(empty($data))
			return 'No';
		else
			return 'Yes';
	}

 /**
  * Check if the given email exists in the specified table, excluding the record with the given ID.
  *
  * @param string $table
  * @param string $email
  * @param string $id
  * @return string 'Yes' if the email exists (excluding the record with the given ID), 'No' otherwise
  */
	function check_other_email($table,$email,$id='') {
		$this->db->select('*');
		$this->db->where('email', $email);
		if($id != '')
			$this->db->where('id !=', $id);
		$query = $this->db->get($table);
		$data = $query->row_array();
		if(empty($data))
			return 'No';
		else
			return 'Yes';
	}

 /**
  * Class containing constants for status values and their corresponding text representations.
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
  * Get user data based on the provided user ID or retrieve all users with role 2.
  *
  * @param int|null $userId
  * @return array
  */
	public function getUserData($userId = null)
	{
		if($userId) {
			$sql = "SELECT $this->select_column FROM $this->table WHERE id = ? AND role = ? ";
			$query = $this->db->query($sql, array($userId, 2));
			return $query->row_array();
		}

		$sql = "SELECT $this->select_column FROM $this->table WHERE role = ? ORDER BY id DESC";
		$query = $this->db->query($sql, array(2));
		return $query->result_array();
	}

 /**
  * Retrieve admin user data based on the provided user ID or return all admin users.
  *
  * @param int|null $userId
  * @return array
  */
	public function getAdminUserData($userId = null)
	{
		if($userId) {
			$sql = "SELECT $this->select_column FROM $this->table WHERE id = ? AND role = 1 ";
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}

		$sql = "SELECT $this->select_column FROM $this->table WHERE role = 1 ORDER BY id DESC";
		$query = $this->db->query($sql, array(0));
		return $query->result_array();
	}

 /**
  * Create a new record in the database table with the provided data.
  *
  * @param mixed $data The data to be inserted into the table
  * @return bool True if the record was successfully created, false otherwise
  */
	public function create($data = ''){
		if($data) {
			$create = $this->db->insert($this->table, $data);
			return ($create == true) ? true : false;
		}
	}

 /**
  * Add a new user to the database with the provided data and return the user ID.
  *
  * @param string $data
  * @return int The ID of the newly added user, or 0 if the user creation failed.
  */
	public function addUserAndGetId($data = ''){
		if($data) {
			$create = $this->db->insert($this->table, $data);
			if($create == true)
			{
				return $this->db->insert_id();
			}
			else
			{
				return 0;	
			}
		}
	}

 /**
  * Edit a record in the database table with the provided data and ID.
  *
  * @param array $data The data to be updated in the record.
  * @param int|null $id The ID of the record to be updated.
  * @return bool Returns true if the record was successfully updated, false otherwise.
  */
	public function edit($data = array(), $id = null)
	{
		$this->db->where('id', $id);
		$update = $this->db->update($this->table, $data);

		return ($update == true) ? true : false;
	}

    /**
     * Get the value of the option based on the provided key.
     *
     * @param mixed $value
     * @return mixed|string
     */
    public static function getOptionValue($value) {
        if(!$value){
            return $value;
        }

        return (isset(self::$status[$value])) ? self::$status[$value] : '';
    }

    /**
     * Register a new user by inserting the provided data into the database table.
     *
     * @param array $data The data to be inserted for the new user.
     * @return bool True if the user registration was successful, false otherwise.
     */
    public function register_user($data) {
        return $this->db->insert($this->table, $data);
    }

 /**
  * Save the reset token for a user with the given email.
  *
  * @param string $email The email of the user
  * @param string $token The reset token to be saved
  * @return void
  */
	public function saveResetToken($email, $token) {
        $this->db->where('email', $email);
        $this->db->update($this->table, ['reset_token' => $token]);
    }

 /**
  * Update the user's password using the provided reset token.
  *
  * @param string $token The reset token associated with the user.
  * @param string $password The new password to be set.
  * @return bool Returns true if the password update was successful, false otherwise.
  */
	public function updatePasswordByResetToken($token, $password)
	{	
		$this->db->where('reset_token', $token);
        $query = $this->db->get($this->table);
        if ($query->num_rows() == 1) {
            $user = $query->row();
            $this->db->where('reset_token', $token);
            $this->db->update($this->table, ['password' => password_hash($password, PASSWORD_DEFAULT), 'reset_token' => NULL]);
            return $this->db->affected_rows() > 0;
		}
		else
		{
			return false;
		}
	}

 /**
  * Retrieve a user from the database based on the provided reset token.
  *
  * @param string $token The reset token to search for.
  * @return mixed The user object if found, or null if not found.
  */
	public function getUserByResetToken($token)
	{
		$query = $this->db->get_where($this->table, ['reset_token' => $token]);
    	return $query->row();
	}

    /**
     * Check if the given email exists in the 'users' table.
     *
     * @param string $email The email to check for existence
     * @return bool True if the email exists, false otherwise
     */
    public function isEmailExists($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');

      if ($query->num_rows() > 0) {
        return true;
      }
      else
      {
        return false;
      }
    }

 /**
  * Retrieves user data from the database based on the provided email and role.
  *
  * @param string $email The email of the user
  * @param string $role The role of the user
  * @return mixed Returns the user data as an object if found, otherwise returns null
  */
	public function getUserDataByEmail($email,$role)
	{
		$this->db->where('email', $email);
		$this->db->where('role', $role);
        $query = $this->db->get($this->table); 
        
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
	}

     /**
      * Authenticates a user based on the provided username, password, and role.
      *
      * @param string $username The username of the user
      * @param string $password The password of the user
      * @param string $role The role of the user
      * @return mixed Returns the user object if authentication is successful, false otherwise
      */
     public function authenticate($username, $password, $role) {
        $query = $this->db->get_where($this->table, ['email' => $username,'status' => self::STATUS_ACTIVE,'role' => $role]);
        $user = $query->row();

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user->password)) {
            return $user;
        } else {
            return false;
        }
    }

    /**
     * Increments the login attempts for a specific user identified by user_id.
     *
     * @param int $user_id The ID of the user
     * @return void
     */
    public function incrementLoginAttempts($user_id) {
        $this->db->where('id', $user_id);
        $this->db->where('role', '2');
        $this->db->set('login_attempts', 'login_attempts+1', FALSE);
        $this->db->update($this->table);
    }

    /**
     * Retrieves a user from the database based on the provided username.
     *
     * @param string $username The username of the user to retrieve.
     * @return object|null The user object if found, or null if not found.
     */
    public function getUserByUsername($username) {
        $query = $this->db->get_where($this->table, ['email' => $username]);
        return $query->row();
    }

     /**
      * Reset the login attempts for a user with the given email address.
      *
      * @param string $email The email address of the user
      * @return void
      */
     public function resetLoginAttempts($email) {
        $this->db->where('email', $email);
        $this->db->set('login_attempts', 0);
        $this->db->update($this->table);
     }

     /**
      * Retrieves the admin data from the database based on the provided email.
      *
      * @param string $email The email of the admin to retrieve data for.
      * @return array|null An associative array containing the admin data if found, or null if not found.
      */
     public function getAdminData($email)
     {
        $getAdminData = $this->db->get_where($this->table, ['email' => $email,'role' => 1]);
        return $getAdminData->row_array();
     }

    /**
     * Reset the OTP (One-Time Password) code for a specific user.
     *
     * @param int $user_id The ID of the user for whom the OTP code needs to be reset.
     * @return void
     */
    public function resetOtp($user_id) {
        $this->db->set('otp_code', NULL);
        $this->db->where('id', $user_id);
        $this->db->update($this->table);
    }

 /**
  * Constructs a query based on the provided search criteria and order parameters.
  * The query filters records based on the search string and role condition.
  * It also orders the results based on the specified column and direction.
  */
	public function make_query()
	{
		$this->db->from($this->table);
		$this->db->where('role !=', '1');
		if ($_POST["search"]["value"]!='') {
			$searchString = $_POST["search"]["value"];
			$this->db->where("(first_name LIKE '%".$searchString."%' OR last_name LIKE '%".$searchString."%' OR email LIKE '%".$searchString."%' OR phone LIKE '%".$searchString."%' OR status LIKE '%".$searchString."%' OR id LIKE '%".$searchString."%')", NULL, FALSE);

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
  * @return array The result of the query for DataTables
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
  * Retrieves filtered data based on the query conditions.
  *
  * This method executes the query built by the 'make_query' method and retrieves the result set.
  *
  * @return int The number of rows in the result set.
  */
	public function get_filtered_data()
	{
		$this->make_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

 /**
  * Retrieves the count of all data from the 'users' table where the role is not equal to 1.
  *
  * @return int The total count of records that meet the specified criteria.
  */
	public function get_all_data()
	{
		$this->db->select("*");
		$this->db->from('users');
		//$this->db->where('id !=', 1);
		$this->db->where('role !=', '1');
		return $this->db->count_all_results();
	}

 /**
  * Update the image of a user in the database.
  *
  * @param int $userId The ID of the user whose image is to be updated.
  * @param string $fileName The new image file name.
  * @return void
  */
	public function updateUserImage($userId,$fileName)
	{
		$data = [
    		'image' => $fileName, 
		];
		$this->db->where('id', $userId); // Assuming 'user_id' is the column name for the user ID
		$this->db->update('users', $data);
		return;
	}

 /**
  * Delete a record from the database based on the given ID.
  *
  * @param int $id The ID of the record to be deleted
  * @return bool True if the record was successfully deleted, false otherwise
  */
	public function delete($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete($this->table);
		return ($delete == true) ? true : false;
	}

  /**
 * Retrieve all user first names and their corresponding IDs from the database.
 * 
 * @return array An array containing user IDs and first names.
 */
  public function getAllFrontUsersFirstNames()
  {
      $this->db->select("id, CONCAT(first_name, ' ', last_name) as first_name");
      $this->db->where('role', 2);
      $query = $this->db->get($this->table);

      if ($query->num_rows() > 0) {
          return $query->result_array();
      } else {
          return [];
      }
  }

}

