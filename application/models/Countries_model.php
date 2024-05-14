<?php

/**
 * Countries_model Class
 *
 * This class serves as the model for handling country-related data.
 */
class Countries_model extends CI_Model
{   
    public $table = "countries";
    public $select_column = ['id','country_mobile_code','country_code'];

    public function __construct(){
		parent::__construct();
	}


 /**
  * Retrieves an array of country mobile codes from the database.
  *
  * @return array An array containing country mobile codes.
  */
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

  public function getCountrCodeWiseCountry()
	{
		$this->db->select('country_code, name');
    $this->db->order_by('name');
		$query = $this->db->get($this->table);
		$countryName = [];
        foreach ($query->result() as $row) {
            $countryName[$row->country_code] = $row->name;
        }
        return $countryName;
	}
}