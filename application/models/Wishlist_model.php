<?php
class Wishlist_model extends CI_Model
{   
    public $table = " wishlists";
    public function __construct(){
		  parent::__construct();
	  }

        public function getWishlistItems($user_id) {

            $this->db->select('*');
            $this->db->from('wishlists');
            $this->db->where('user_id', $user_id);
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) {
    
                return $query->result_array();
            } else {
                
                return array();
        }
}

        public function deleteFromWishlist($id)
        {
            $this->db->where('product_id', $id);
            $deleted = $this->db->delete('wishlists');
            return $deleted;
        }

     

}