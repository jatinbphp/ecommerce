<?php
class Countries_model extends CI_Model
{   
    public $table = "countries";
    public $select_column = ['id','country_mobile_code','country_code'];

    public function __construct(){
		parent::__construct();
	}


	public function getCountryData()
	{
		$this->db->select('country_mobile_code');
		$query = $this->db->get('countries');
		$country_mobile_codes = array();
        foreach ($query->result() as $row) {
            $country_mobile_codes[$row->country_mobile_code] = $row->country_mobile_code;
        }
        return $country_mobile_codes;
	}
}