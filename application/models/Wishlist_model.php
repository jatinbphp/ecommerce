<?php

/**
 * Wishlist_model Class
 *
 * This class serves as the model for managing wishlist data.
 */
class Wishlist_model extends CI_Model
{   
    public $table = " wishlists";
    
    /**
     * Constructor for the class.
     *
     * Calls the parent class constructor.
     */
    public function __construct(){
	    parent::__construct();
	}

    /**
     * Retrieves wishlist items for a specific user based on the user ID.
     *
     * @param int $user_id The ID of the user to retrieve wishlist items for
     * @return array An array of wishlist items if found, otherwise an empty array
     */
    public function getWishlistItems($user_id) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return [];
    }

    /**
     * Delete a product from the wishlist based on the given product ID.
     *
     * @param int $id The ID of the product to be deleted from the wishlist
     * @return bool True if the product was successfully deleted, false otherwise
     */
    public function deleteFromWishlist($id)
    {
        $this->db->where('product_id', $id);
        $deleted = $this->db->delete($this->table);
        return $deleted;
    }

    public function getWishlistProductIds(){
        $userId = $this->session->userdata('userId');
        
        if(!$userId){
            return [];
        }

        $this->db->select('product_id');
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }
}