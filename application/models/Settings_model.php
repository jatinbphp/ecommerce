<?php
/**
 * Settings_model Class
 *
 * This class represents the model for managing settings in the CodeIgniter application.
 * It extends the CI_Model class provided by CodeIgniter, which is a base model class that
 * provides basic functionalities for interacting with the database.
 */
class Settings_model extends CI_Model
{   
    public $table = "settings";
    public function __construct(){
		  parent::__construct();
	  }

  /**
   * Update a record in the database with the specified ID using the provided data.
   *
   * @param int $id The ID of the record to update
   * @param array $data The data to update the record with
   * @return void
   */
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows() > 0;
    }

    /**
     * Get the settings from the database based on the provided ID.
     *
     * @param int $id The ID of the settings to retrieve.
     * @return array|null The settings as an associative array, or null if not found.
     */
    public function getSettingsById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row_array(); 
    }

}