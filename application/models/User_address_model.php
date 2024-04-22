<?php

class User_address_model extends CI_Model
{   
    public $table = "user_addresses";
    
    public function __construct(){
		parent::__construct();
	}

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function getUserAddresses($userId)
    {
        return $this->db->get_where($this->table, array('user_id' => $userId))->result_array();
    }

    public function deleteAddress($id)
    {
        $this->db->where('id', $id);
        $deleted = $this->db->delete('user_addresses');
        return $deleted;
    }

    public function update_address($userId, $data)
    {
        $this->db->where('id', $userId);
        $this->db->update('user_addresses', $data);
    }

    public function getAddressDetails($address_id)
    {
        return $this->db->get_where($this->table, array('id' => $address_id))->row_array();
    }

}