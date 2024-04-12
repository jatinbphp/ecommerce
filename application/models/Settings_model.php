<?php
class Settings_model extends CI_Model
{   
    public $table = "settings";
    public function __construct(){
		  parent::__construct();
	  }

  public function update($id, $data)
  {
      $this->db->where('id', $id);
      $this->db->update($this->table, $data);
      return $this->db->affected_rows() > 0;
  }

  public function getSettingsById($id)
  {
      $this->db->where('id', $id);
      $query = $this->db->get($this->table);
      return $query->row_array(); 
  }

}