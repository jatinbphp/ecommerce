<?php
/**
 * Cart_model Class
 *
 * This class serves as the model for managing the cart data in the CodeIgniter application.
 */
class Cart_model extends CI_Model
{   
    public $table = "carts";
    public $select_column = ['id','order_id','user_id','product_id','quantity','options','options_text','created_at','updated_at'];

    /**
     * Constructor method for the class.
     * Loads the ProductImage_model and calls the parent constructor.
     */
    public function __construct(){
		$this->load->model('ProductImage_model');
		parent::__construct();
	}

	const STATUS_ACTIVE        = 'active';
    const STATUS_INACTIVE      = 'inactive';
    const STATUS_ACTIVE_TEXT   = "Active";
    const STATUS_INACTIVE_TEXT = "In Active";

    public static $status = [
        self::STATUS_ACTIVE   => self::STATUS_ACTIVE_TEXT,
        self::STATUS_INACTIVE => self::STATUS_INACTIVE_TEXT,
    ];


	/**
	 * Create a new record in the database table with the given data.
	*
	* @param array $data The data to be inserted into the table.
	* @return int The ID of the newly created record.
	*/
	public function create($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}


	/**
	 * Retrieves the count of items in the cart for a specific user.
	*
	* @param int $userId The ID of the user
	* @return int The count of items in the cart for the specified user
	*/
	public function cartCounter($userId)
	{
		$this->db->select('COUNT(*) as count');
        $this->db->from($this->table);
        $this->db->where('user_id', $userId);
        $query = $this->db->get();

        $result = $query->row();
        $cartCount = $result->count;
        return $cartCount;	
	}

 /**
  * Retrieves the user's cart data based on the provided user ID.
  *
  * @param int $userId The ID of the user whose cart data is to be retrieved
  * @return array An array containing the user's cart data
  */
	public function getUsrCartData($userId)
	{
		$cartProducts = [];
        $this->db->select($this->table.'.id as cartId,'.$this->table.'.*,  products.*');
        $this->db->from($this->table);
        $this->db->join('products', 'products.id = carts.product_id');
        $this->db->where('carts.user_id', $userId);
        $this->db->where('products.status', self::STATUS_ACTIVE);
        $this->db->order_by('carts.created_at', 'DESC');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $getCartData = $query->result_array();

            foreach ($getCartData as $key => $row) {

            	if(isset($row['options']) && $row['options'] != '')
        		{
        			$optionArray = array();
        			$getOptionsData = json_decode($row['options'],true);

        			if(count($getOptionsData) > 0)
    				{
    					foreach($getOptionsData as $optKey => $optval)
						{
							$this->db->select('*');
							$this->db->from('products_options');
							$this->db->where('id', $optKey);
							$query = $this->db->get();
							$product_option = $query->row();


							$this->db->select('*');
							$this->db->from('products_options_values');
							$this->db->where('id', $optval);
							$query = $this->db->get();
							$product_option_value = $query->row();

							
							if ($product_option && $product_option_value) {
							    $optionArray[$product_option->option_name] = $product_option_value->option_value;
							}

						}
    				}
        		}
				$productImages = $this->ProductImage_model->getDetails($row['id']);
				$firstProductImage = current($productImages);
				$row['image'] = ($firstProductImage['image'] ?? '');

        		$cartProducts[$key]['cart_data'] = ['productData' => $row,'productOptions' => $optionArray];
        	}
        }

	    return $cartProducts;
	}

	/**
	 * Retrieves guest user cart data based on the provided user cart data.
	*
	* @param array $userCartData An array containing user cart data
	* @return array An array containing guest user cart data
	*/
	public function getGuestUserCartData($userCartData) {
		if(!$userCartData || !count($userCartData)){
			return [];
		}
		$cartProducts = [];
		foreach ($userCartData as $key => $cartData) {
			$productId = $cartData['product_id'] ?? 0;
			if(!$productId){
				continue;
			}
			
			$this->db->select('products.*, products.id as product_id');
			$this->db->from('products');
			$this->db->where('products.id', $productId);
			$this->db->where('products.status', 'active');
			$query = $this->db->get();
			$productData = $query->result_array();

			foreach ($productData as $row) {
				$row['quantity'] = ($cartData['quantity'] ?? 0);
				$row['options'] = (json_encode($cartData['options']) ?? '');
				if(isset($cartData['options']) && count($cartData['options'])){
					$optionArray = [];
					foreach($cartData['options'] as $optKey => $optval){
						$this->db->select('*');
						$this->db->from('products_options');
						$this->db->where('id', $optKey);
						$query = $this->db->get();
						$product_option = $query->row();


						$this->db->select('*');
						$this->db->from('products_options_values');
						$this->db->where('id', $optval);
						$query = $this->db->get();
						$product_option_value = $query->row();

						
						if ($product_option && $product_option_value) {
							$optionArray[$product_option->option_name] = $product_option_value->option_value;
						}

					}
				}
				$productImages = $this->ProductImage_model->getDetails($row['id']);
				$firstProductImage = current($productImages);
				$row['image'] = ($firstProductImage['image'] ?? '');
				$cartProducts[$key]['cart_data'] = ['productData' => $row,'productOptions' => $optionArray];
			}
		}

		return $cartProducts;
	}

	/**
	 * Deletes a specific cart item from the database based on the provided cart ID.
	*
	* @param int $cartId The ID of the cart item to be deleted.
	* @return bool Returns true if the cart item was successfully deleted, false otherwise.
	*/
	public function deleteCartItem($cartId)
	{
		$userId = $this->session->userdata('userId');
		if(!empty($userId)){
	    	$this->db->where('id', $cartId);
	    	$this->db->delete($this->table);
	    	return $this->db->affected_rows() > 0;
    	}
	}

	/**
	 * Get the count of items in the user's cart.
	*
	* This method retrieves the user ID from the session data, queries the database to count the items in the user's cart,
	* and returns the count.
	*
	* @return int|null The count of items in the user's cart, or null if the user ID is not set.
	*/
	public function getUserCartCounter()
	{
		$userId = $this->session->userdata('userId');
		if(isset($userId) && $userId != '')
		{
			$this->db->select('COUNT(*) as count');
	        $this->db->from($this->table);
	        $this->db->where('user_id', $userId);
	        $query = $this->db->get();

	        $result = $query->row();
	        $cartCount = $result->count;
	        return $cartCount;

		}
	}

	/**
	 * Delete a record from the database table based on the user ID.
	*
	* @param int $userId
	* @return bool
	*/
	public function deleteByUserId($userId)
	{
		$this->db->where('user_id', $userId);
		$delete = $this->db->delete($this->table);
		return ($delete == true) ? true : false;
	}

}