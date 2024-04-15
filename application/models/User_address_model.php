<?php

class User_address_model extends CI_Model
{   
    public $table = "user_addresses";
    public $select_column = '*';
    

	public function __construct(){
		parent::__construct();
	}

	public function createByUser($data) {    
        $create = $this->db->insert($this->table, $data);
        return ($create) ? true : false;
        
    }

    public function getUserAddresses($usrId)
    {
         $getData = [];
        if ($usrId) {
            $sql = "SELECT $this->select_column FROM $this->table WHERE user_id = ?";
            $query = $this->db->query($sql, [$usrId]);
            $result = $query->result_array(); // Fetch all rows as an array of associative arrays
            
            if (!empty($result)) {
                $recCnt = 1;
                foreach ($result as $row) {
                    
                    $getData[$recCnt]['id'] = $row['id'];
                    $getData[$recCnt]['title'] = $row['title'];
                    $getData[$recCnt]['first_name'] = $row['first_name'];
                    $getData[$recCnt]['last_name'] = $row['last_name'];
                    $getData[$recCnt]['company'] = $row['company'];
                    $getData[$recCnt]['mobile_phone'] = $row['mobile_phone'];
                    $getData[$recCnt]['address_line1'] = $row['address_line1'];
                    $getData[$recCnt]['address_line2'] = $row['address_line2'];
                    $getData[$recCnt]['pincode'] = $row['pincode'];
                    $getData[$recCnt]['city'] = $row['city'];
                    $getData[$recCnt]['state'] = $row['state'];
                    $getData[$recCnt]['country'] = $row['country'];
                    $getData[$recCnt]['additional_information'] = $row['additional_information'];
                    $recCnt++;
                }
            }
        }

        return $getData;
    }

    public function updateAddress($id,$data)
    {
        $address_data = [
            'title' => $data['title'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'company' => $data['company'],
            'mobile_phone' => $data['mobile_phone'],
            'address_line1' => $data['address_line1'],
            'address_line2' => $data['address_line2'],
            'pincode' => $data['pincode'],
            'country' => $data['country'],
            'state' => $data['state'],
            'city' => $data['city'],
            'additional_information' => $data['additional_information']
        ];

        $this->db->where('id', $id);
        $this->db->update($this->table, $address_data);

        if ($this->db->affected_rows() > 0) {
            return true; // Address updated successfully
        } else {
            return false; // Failed to update address
        }

    }

    public function deleteAddress($addressId) {
        $this->db->where('id', $addressId);
        $this->db->delete($this->table);

        // Check if delete was successful
        return $this->db->affected_rows() > 0;
    }

    public function deleteUserAddress($userId) {
        $this->db->where('user_id', $userId);
        $this->db->delete($this->table);
        
        return $this->db->affected_rows() > 0;
    }

}
