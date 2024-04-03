<?php
class User_model extends CI_Model {

	public function getStudentData($studentId = null)
	{
		if($studentId) {
			$sql = "SELECT * FROM users WHERE id = ? AND role += '2' ";
			$query = $this->db->query($sql, array($studentId));
			return $query->row_array();
		}

		$sql = "SELECT * FROM users WHERE role == '2' ORDER BY id DESC";
		$query = $this->db->query($sql, array(0));
		return $query->result_array();
	}

	public function edit($data = array(), $id = null)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('users', $data);

		return ($update == true) ? true : false;
	}

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

	const STATUS_ACTIVE        = 1;
    const STATUS_INACTIVE      = 0;
    const STATUS_ACTIVE_TEXT   = "Active";
    const STATUS_INACTIVE_TEXT = "In Active";

    public static $status = [
        self::STATUS_ACTIVE   => self::STATUS_ACTIVE_TEXT,
        self::STATUS_INACTIVE => self::STATUS_INACTIVE_TEXT,
    ];

    public static function getOptionValue($value) {
        if(!$value){
            return $value;
        }

        return (isset(self::$status[$value])) ? self::$status[$value] : '';
    }

    public function register_user($data) {
        return $this->db->insert('users', $data);
    }

    public function check_email_exists($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
    }

     public function authenticate($username, $password, $role) {
        $query = $this->db->get_where('users', array('email' => $username,'status' => self::STATUS_ACTIVE,'role' => $role));
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
        $this->db->update('users');
    }

    public function getUserByUsername($username) {
        $query = $this->db->get_where('users', array('email' => $username));
        return $query->row();
    }

     public function resetLoginAttempts($email) {
        $this->db->where('email', $email);
        $this->db->set('login_attempts', 0);
        $this->db->update('users');
     }

     public function getAdminData($email)
     {
        $getAdminData = $this->db->get_where('users', array('email' => $email,'role' => 1));
        return $getAdminData->row_array();
     }

    public function reset_otp($user_id) {
        $this->db->set('otp_code', NULL);
        $this->db->where('id', $user_id);
        $this->db->update('users');
    }
}

