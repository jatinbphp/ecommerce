<?php
class User_model extends CI_Model 
{
	public $table = "users";
    public $select_column = '*';
    public $order_column = ['id', 'first_name', 'first_name', 'email', 'phone', 'status', 'created_at'];

    const STATUS_ACTIVE        = "active";
    const STATUS_INACTIVE      = "inactive";
    const STATUS_ACTIVE_TEXT   = "Active";
    const STATUS_INACTIVE_TEXT = "In Active";

    public static $status = [
        self::STATUS_ACTIVE   => self::STATUS_ACTIVE_TEXT,
        self::STATUS_INACTIVE => self::STATUS_INACTIVE_TEXT,
    ];

	public function getUserData($userId = null)
	{
		if($userId) {
			$sql = "SELECT $this->select_column FROM $this->table WHERE id = ? AND role = 2 ";
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}

		$sql = "SELECT $this->select_column FROM $this->table WHERE role = 2 ORDER BY id DESC";
		$query = $this->db->query($sql, array(0));
		return $query->result_array();
	}

	public function create($data = ''){
		if($data) {
			$create = $this->db->insert($this->table, $data);
			return ($create == true) ? true : false;
		}
	}

	public function edit($data = array(), $id = null)
	{
		$this->db->where('id', $id);
		$update = $this->db->update($this->table, $data);

		return ($update == true) ? true : false;
	}

    public static function getOptionValue($value) {
        if(!$value){
            return $value;
        }

        return (isset(self::$status[$value])) ? self::$status[$value] : '';
    }

    public function register_user($data) {
        return $this->db->insert($this->table, $data);
    }

	public function saveResetToken($email, $token) {
        $this->db->where('email', $email);
        $this->db->update($this->table, ['reset_token' => $token]);
    }

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

	public function getUserByResetToken($token)
	{
		$query = $this->db->get_where($this->table, ['reset_token' => $token]);
    	return $query->row();
	}

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

	public function getUserDataByEmail($email,$role)
	{
		$this->db->where('email', $email);
		$this->db->where('role', $role);
        $query = $this->db->get($this->this); 
        
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
	}

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

    public function incrementLoginAttempts($user_id) {
        $this->db->where('id', $user_id);
        $this->db->set('login_attempts', 'login_attempts+1', FALSE);
        $this->db->update($this->table);
    }

    public function getUserByUsername($username) {
        $query = $this->db->get_where($this->table, ['email' => $username]);
        return $query->row();
    }

     public function resetLoginAttempts($email) {
        $this->db->where('email', $email);
        $this->db->set('login_attempts', 0);
        $this->db->update($this->table);
     }

     public function getAdminData($email)
     {
        $getAdminData = $this->db->get_where($this->table, ['email' => $email,'role' => 1]);
        return $getAdminData->row_array();
     }

    public function resetOtp($user_id) {
        $this->db->set('otp_code', NULL);
        $this->db->where('id', $user_id);
        $this->db->update($this->table);
    }

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

	public function make_datatables()
	{
		$this->make_query();
		if ($_POST["length"] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function get_filtered_data()
	{
		$this->make_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_all_data()
	{
		$this->db->select("*");
		$this->db->from('users');
		//$this->db->where('id !=', 1);
		$this->db->where('role !=', '1');
		return $this->db->count_all_results();
	}
}

