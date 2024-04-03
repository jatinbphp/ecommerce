<?php
class User_model extends CI_Model {

	public function getUserData($studentId = null)
	{
		if($studentId) {
			$sql = "SELECT * FROM users WHERE id = ? AND role += 2 ";
			$query = $this->db->query($sql, array($studentId));
			return $query->row_array();
		}

		$sql = "SELECT * FROM users WHERE role = 2 ORDER BY id DESC";
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

     public function authenticate($username, $password) {
        $query = $this->db->get_where('users', array('email' => $username,'status' => self::STATUS_ACTIVE));
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

    public function reset_otp($user_id) {
        $this->db->set('otp_code', NULL);
        $this->db->where('id', $user_id);
        $this->db->update('users');
    }

	public function make_query()
	{
		$this->db->from('users');
		$this->db->where('role !=', '1');
		if ($_POST["search"]["value"]!='') {
			$searchString = $_POST["search"]["value"];
			$this->db->where("(username LIKE '%".$searchString."%' OR firstname LIKE '%".$searchString."%' OR lastname LIKE '%".$searchString."%' OR email LIKE '%".$searchString."%' OR phone LIKE '%".$searchString."%')", NULL, FALSE);

		}
		if (isset($_POST['order'][0]['column'])) {
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

