<?php 

/**
 * Product_model Class
 *
 * This class serves as the model for products.
 * It extends the CI_Model class provided by CodeIgniter, allowing it to interact with the database.
 */
class Product_model extends CI_Model
{   
    public $table = "products";
    public $select_column = ['*'];
    public $order_column = ['id', 'product_name', 'sku', 'price', 'status', 'created_at'];

	public function __construct(){
        $this->load->model('ProductImage_model');
        $this->load->model('ProductOptions_model');
        $this->load->model('ProductOptionValues_model');
		parent::__construct();
	}

    /**
    * Class containing constants for status values and their corresponding text representations.
    */
	const STATUS_ACTIVE        = 'active';
    const STATUS_INACTIVE      = 'inactive';
    const STATUS_ACTIVE_TEXT   = "Active";
    const STATUS_INACTIVE_TEXT = "In Active";

    public static $status = [
        self::STATUS_ACTIVE   => self::STATUS_ACTIVE_TEXT,
        self::STATUS_INACTIVE => self::STATUS_INACTIVE_TEXT,
    ];

    /*product stock status*/
    const STATUS_IN_STOCK       = 'in_stock';
    const STATUS_OUT_OF_STOCK   = 'out_of_stock';
    const STATUS_PRE_ORDER      = 'pre_order';
    const STATUS_BACKORDER      = 'backorder';
    const STATUS_DISCONTINUED   = 'discontinued';

    const STATUS_IN_STOCK_TEXT       = 'In Stock';
    const STATUS_OUT_OF_STOCK_TEXT   = 'Out of Stock';
    const STATUS_PRE_ORDER_TEXT      = 'Pre-order';
    const STATUS_BACKORDER_TEXT      = 'Backorder';
    const STATUS_DISCONTINUED_TEXT   = 'Discontinued';

    public static $stock_status = [
        self::STATUS_IN_STOCK       => self::STATUS_IN_STOCK_TEXT,
        self::STATUS_OUT_OF_STOCK   => self::STATUS_OUT_OF_STOCK_TEXT,
        self::STATUS_PRE_ORDER      => self::STATUS_PRE_ORDER_TEXT,
        self::STATUS_BACKORDER      => self::STATUS_BACKORDER_TEXT,
        self::STATUS_DISCONTINUED   => self::STATUS_DISCONTINUED_TEXT,
    ];

    /*product quantity*/
    public static $quantity = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

    /*product type*/
    public static $type = [
        'new'   => '<span class="badge bg-info text-white position-absolute ft-regular ab-left text-upper">New</span>',
        'sale'  => '<span class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">sale</span>',
        'hot'   => '<span class="badge bg-danger text-white position-absolute ft-regular ab-left text-upper">hot</span>'
    ];


    /**
    * Get the details of a product by its ID or return all products if no ID is provided.
    *
    * @param int|null $productId
    * @return array
    */
	public function getDetails($productId = null) {
		if($productId) {
			$sql = "SELECT * FROM $this->table WHERE id = ?";
			$query = $this->db->query($sql, array($productId));
			return $query->row_array();
		}

		$sql = "SELECT * FROM $this->table ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    /**
    * Create a new record in the database table with the provided data.
    *
    * @param mixed $data The data to be inserted into the table.
    * @return int The ID of the newly created record, or 0 if creation fails or no data is provided.
    */
	public function create($data = ''){
		if($data) {
            $data = $this->setSlug($data);
			$create = $this->db->insert($this->table, $data);
            if ($create) {
                return $this->db->insert_id();
            } else {
                return 0;
            }
		}
        return 0;
	}

 /**
  * Edit a record in the database table with the provided data and ID.
  *
  * @param array $data The data to be updated
  * @param int|null $id The ID of the record to be updated
  * @return bool Returns true if the update was successful, false otherwise
  */
	public function edit($data = array(), $id = null){
        $data = $this->setSlug($data);
		$this->db->where('id', $id);
		$update = $this->db->update($this->table, $data);
		return ($update == true) ? true : false;	
	}

    /**
     * Set the slug for the given data based on the 'name' field.
     *
     * @param array $data
     * @return array
     */
    public function setSlug($data) {
        if(!isset($data['product_name'])){
           return $data;
        }

        $name = $data['product_name'];
        $slug = strtolower($name);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim($slug, '-');
        
        $this->db->select('id');
        $this->db->from($this->table);
        $this->db->where('slug', $slug);
        if(isset($data['id']) && $data['id']){
            $this->db->where('id !=', $data['id']);
        }
        $query = $this->db->get();
        $query->num_rows();
        

        if ($query->num_rows() > 0) {
            $data['slug'] = $slug . '-' . ($query->num_rows() + 1);
        } else {
            $data['slug'] = $slug;
        }

        return $data;

    }

     /**
     * Get the product ID based on the provided slug.
     *
     * @param string $slug The slug of the product.
     * @return string The ID of the product corresponding to the given slug, or an empty string if not found.
     */
    public function getProductIdBasedOnSlug($slug) {
        if(!$slug){
            return '';
        }
		$sql = "SELECT `id` FROM $this->table WHERE slug = ?  ORDER BY id DESC";
		$query = $this->db->query($sql, array($slug));
		$result = $query->row_array();
        return ($result['id'] ?? '');
    }


 /**
  * Delete a record from the database based on the given ID.
  *
  * @param int $id The ID of the record to delete
  * @return bool True if the record was successfully deleted, false otherwise
  */
	public function delete($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete($this->table);
		return ($delete == true) ? true : false;
	}

    /**
     * Constructs a query based on the provided search and order parameters.
     * 
     * @return void
     */
    public function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        if ($_POST["search"]["value"]!='') {
            $searchString = $_POST["search"]["value"];
            $this->db->where("(id LIKE '%".$searchString."%' OR product_name LIKE '%".$searchString."%' OR sku LIKE '%".$searchString."%' OR price LIKE '%".$searchString."%' OR status LIKE '%".$searchString."%')", NULL, FALSE);
        }

        if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
            $this->db->order_by($this->order_column[$_POST['order'][0]['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'DESC');
        }        
    }

    /**
     * Generate data for DataTables.
     *
     * This method prepares the query for DataTables based on the POST parameters.
     * It limits the query results based on the length and start parameters.
     *
     * @return array The result data for DataTables.
     */
    public function make_datatables()
    {
        $this->make_query();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Retrieves and returns the number of rows from the filtered data based on the query.
     *
     * @return int
     */
    public function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Retrieves all data from the specified table.
     *
     * @return int The total count of rows in the table.
     */
    public function get_all_data()
    {
        $this->db->select("*");
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    /**
     * Retrieves products along with their images based on the provided product IDs.
     *
     * @param array $product_ids An array containing the IDs of the products to retrieve.
     * @return array An array of products with their corresponding images.
     */
    public function getProductsByIds($product_ids) {
        if(empty($product_ids)){
            return [];
        }

        $this->db->select('products.*, product_images.image');
        $this->db->from('products');
        $this->db->join('product_images', 'products.id = product_images.product_id', 'left');
        $this->db->where_in('products.id', $product_ids);
        $this->db->group_by('products.id, product_images.image');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $products_with_images = [];
            foreach ($query->result() as $row) {
                $product_data = (array)$row;
                $product_id = $product_data['id'];
                unset($product_data['image']);
                if (!isset($products_with_images[$product_id])) {
                    $products_with_images[$product_id] = [
                        'product_details' => $product_data,
                        'image' => []
                    ];
                }
                $products_with_images[$product_id]['image'][] = $row->image;
            }
            return $products_with_images;
        }
        return [];
    }
    
    /**
     * Retrieves the latest active products along with their images.
     *
     * @return array An array of the latest active products with their images.
     */
    public function getLatestProducts(){
        $this->db->select('products.*');
        $this->db->from($this->table);
        $this->db->where('products.status', self::STATUS_ACTIVE);
        $this->db->group_by('products.id'); // Group by product ID to aggregate images
        $this->db->order_by('products.created_at', 'DESC');
        $this->db->limit(8);
        $query = $this->db->get();
        $row = $query->result_array();
        
        if(!$row || !count($row)){
            return [];
        }

        $rowData = [];
        foreach($row as $data){
            $id = ($data['id'] ?? 0);
            if(!$id){
                continue;
            }

            $data['images'] = array_column($this->ProductImage_model->getDetails($id), 'image');
            $rowData[] = $data;
        }
        return $rowData;
    }

    /**
     * Get filtered products based on the specified category ID.
     *
     * @param int $categoryId The ID of the category to filter by. Defaults to 0.
     * @return array An array of filtered products with additional image information.
     */
    public function filter_products($filters){
        $categoryId = $filters['categoryId'] ?? [];
        $priceRange = $filters['priceRange'] ?? [];
        $sort       = $filters['sort'] ?? 0;
        unset($filters['categoryId']);
        unset($filters['priceRange']);
        unset($filters['sort']);
      
        $filterOptionsProductIds = $this->getFilteredProductIds($filters);
       
        $this->db->select('products.*');
        $this->db->from($this->table);

        if($filters && count($filters)){
            if($filterOptionsProductIds && count($filterOptionsProductIds)){
                $this->db->where_in('products.id', $filterOptionsProductIds);
            } else {
                $this->db->where('products.id', 0);
            }
        }
        
        $this->db->where('products.status', self::STATUS_ACTIVE);
        
        if ($categoryId) {
            $this->db->where_in('products.category_id', $categoryId);
        }

        if($priceRange && count($priceRange) == 2){
            $this->db->where('products.price BETWEEN '.$priceRange[0].' AND '.$priceRange[1]);
        }

        $this->db->group_by('products.id');
        
        if($sort == 2){
            $this->db->order_by('products.price', 'ASC');
        } elseif($sort == 3){
            $this->db->order_by('products.price', 'DESC');
        } else {
            $this->db->order_by('products.id', 'DESC');
        }
        $query = $this->db->get();
        
        $row = $query->result_array();
        
        if(!$row || !count($row)){
            return [];
        }

        return $this->addImageForProduct($row);
    }

    /**
     * Add images for each product in the given row.
     *
     * @param array $row
     * @return array
     */
    public function addImageForProduct($row){
        if(!$row || !count($row)){
            return [];
        }

        $rowData = [];
        foreach($row as $data){
            $id = ($data['id'] ?? 0);
            if(!$id){
                continue;
            }

            $data['images'] = array_column($this->ProductImage_model->getDetails($id), 'image');
            $rowData[] = $data;
        }

        return $rowData;
    }

    /**
     * Get filtered product IDs based on the provided filters.
     *
     * @param array $filters An array containing filters to apply.
     * @return array An array of product IDs that match all the provided filters.
     */
    public function getFilteredProductIds($filters) {
        if(!$filters){
            return [];
        }

        $allProductsData = [];

        foreach ($filters as $option => $values) {
            $optionProductsData = [];
        
            $this->db->select('products.id');
            $this->db->from('products');
            $this->db->join('products_options', 'products.id = products_options.product_id', 'left');
            $this->db->join('products_options_values', 'products_options.id = products_options_values.option_id', 'left');
            $this->db->where('products.status', self::STATUS_ACTIVE);
            $this->db->where('LOWER(products_options.option_name)', strtolower($option));
        
            $valueConditions = [];
            
            foreach ($values as $value) {
                $valueConditions[] = "LOWER(products_options_values.option_value) = '" . strtolower($value) . "'";
            }
            $this->db->where('(' . implode(' OR ', $valueConditions) . ')');
        
            $query = $this->db->get();
            $result = $query->result_array();
        
            foreach ($result as $row) {
                $optionProductsData[] = $row['id'];
            }
        
            $allProductsData[] = $optionProductsData;

        }

        $commonProductIds = array_reduce($allProductsData, function ($carry, $item) {
            if ($carry === null) {
                return $item;
            }
            return array_intersect($carry, $item);
        });
        
        return $commonProductIds;
    }

    /**
     * Retrieves and returns detailed information about a specific product identified by its ID.
     *
     * @param int $productId The ID of the product to retrieve
     * @return array|null An associative array containing the product details, including images and category name
     */
    public function show($productId) {
        $this->db->select('products.*, GROUP_CONCAT(product_images.image) as images, categories.name AS category_name');
        $this->db->from($this->table);
        $this->db->join('product_images', 'products.id = product_images.product_id', 'left');
        $this->db->join('categories', 'products.category_id = categories.id', 'left');
        $this->db->where('products.id', $productId);
        $this->db->where('products.status', self::STATUS_ACTIVE);
        $this->db->group_by('products.id'); // Group by product ID to aggregate images
        $query = $this->db->get();
        return $query->row_array();  
    }

    /**
     * Retrieves the count of active products.
     *
     * This function queries the database to count the number of products
     * that are currently marked as 'active'.
     *
     * @return int The count of active products.
     */
    public function getCountOfActiveProducts()
    {
        $this->db->select('COUNT(*) as count');
        $this->db->where('status', 'active');
        $query = $this->db->get($this->table);

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result['count'];
        } else {
            return 0;
        }
    }

    /**
     * Check if a SKU is available in the database.
     *
     * @param string $sku The SKU to check availability for
     * @return bool Returns true if the SKU is available, false otherwise
     */
    public function isSkuAvailable($sku) {
        $this->db->select('sku');
        $this->db->from($this->table);
        $this->db->where('LOWER(sku)', strtolower($sku));
        $query = $this->db->get();
        return $query->num_rows() > 0;
    }

    /**
     * Search for products in the database based on the provided keyword.
     *
     * @param string $keyword The keyword to search for in the product names.
     * @return array An array of products matching the search keyword.
     */
    public function search_products($keyword) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->like('product_name', $keyword);
        $this->db->or_like('sku', $keyword);
        $query = $this->db->get();

        $row = $query->result_array();
        
        if(!$row || !count($row)){
            return [];
        }

        return $this->addImageForProduct($row);
    }

    /**
     * Retrieves and prepares data related to a product based on the provided ID.
     *
     * @param int $id The ID of the product
     * @return array An array containing product information, wishlist product IDs, reviews, user image, stock status, quantity, and options
     */
    public function product_data($id) {
        $this->load->model('Wishlist_model');
        $data['product'] = $this->Product_model->show($id);
        $data['wishlistProductId'] = $this->Wishlist_model->getWishlistProductIds();
        $data['reviews'] = $this->Reviews_model->getDetailsBasedOnProductId($id);
        $data['productWiseReviews']    = $this->Reviews_model->getProductWiseReviewData();
        if($userId   = $this->session->userdata('userId')){
            $user = $this->User_model->getUserData($userId);
            $data['userImage'] = $user['image'];
        }
        if (!empty($data['product'])) {
            $data['product']['stock_status']    = $this->Product_model::$stock_status;
            $data['product']['quantity']        = $this->Product_model::$quantity;
            $data['product']['options']         = $this->ProductOptions_model->getOptionsWithValues($id);
        }

        return $data;
    }
}
