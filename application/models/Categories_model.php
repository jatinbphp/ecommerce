<?php 

/**
 * Categories_model Class
 *
 * This class serves as the model for handling categories in the application.
 * It extends the CI_Model class provided by CodeIgniter, which gives it access to various
 * database methods for interacting with the categories table in the database.
 */
class Categories_model extends CI_Model
{   
    public $table = "categories";
    public $select_column = ['*'];
    public $order_column = ['id', 'name', 'status', 'created_at'];
    protected $_categoryIdWiseName = [];

	public function __construct(){
		parent::__construct();
	}

 /**
  * Constants representing the status of an entity as active or inactive.
  * 
  * STATUS_ACTIVE: Represents the active status.
  * STATUS_INACTIVE: Represents the inactive status.
  * STATUS_ACTIVE_TEXT: Textual representation of the active status.
  * STATUS_INACTIVE_TEXT: Textual representation of the inactive status.
  */
	const STATUS_ACTIVE        = 'active';
    const STATUS_INACTIVE      = 'inactive';
    const STATUS_ACTIVE_TEXT   = "Active";
    const STATUS_INACTIVE_TEXT = "In Active";

    /**
     * Array mapping of status codes to their corresponding text values.
     *
     * @var array
     */
    public static $status = [
        self::STATUS_ACTIVE   => self::STATUS_ACTIVE_TEXT,
        self::STATUS_INACTIVE => self::STATUS_INACTIVE_TEXT,
    ];


    /**
     * Get the details of the item with the specified category ID, or return all items if no category ID is provided.
    *
    * @param int|null $categoryId
    * @return array
    */
	public function getDetails($categoryId = null) {
		if($categoryId) {
			$sql = "SELECT * FROM $this->table WHERE id = ?";
			$query = $this->db->query($sql, array($categoryId));
			return $query->row_array();
		}

		$sql = "SELECT * FROM $this->table ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

 /**
  * Create a new record in the database table with the given data.
  *
  * @param array $data
  * @return int The ID of the newly created record, or 0 if creation fails or no data is provided.
  */
	public function create($data = []){
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
  * @param array $data The data to be updated in the record.
  * @param int|null $id The ID of the record to be updated.
  * @return bool Returns true if the record was successfully updated, false otherwise.
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
        if(!isset($data['name'])){
           return $data;
        }

        $name = $data['name'];
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
     * Delete a record from the database based on the given ID.
    *
    * @param int $id The ID of the record to be deleted
    * @return bool True if the record was successfully deleted, false otherwise
    */
	public function delete($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete($this->table);
		return ($delete == true) ? true : false;
	}

    /**
     * Constructs and prepares a query based on the provided parameters for data retrieval.
     * This method sets the select columns, order by clause, and conditions based on search criteria.
     */
    public function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->order_by('full_path', 'asc');
        $this->db->from($this->table);

        if ($_POST["search"]["value"]!='') {
            $searchString = $_POST["search"]["value"];
            $this->db->where("(name LIKE '%".$searchString."%' OR status LIKE '%".$searchString."%' OR id LIKE '%".$searchString."%')", NULL, FALSE);
        }

        if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
            $this->db->order_by($this->order_column[$_POST['order'][0]['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'DESC');
        }        
    }

    /**
     * Generate data for DataTables.
     * Executes a query based on DataTables parameters and returns the result set.
     *
     * @return array Result set for DataTables
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
     * Retrieves and returns the number of rows from the filtered data based on the constructed query.
     *
     * @return int The number of rows in the result set
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
     * Retrieves an array of categories with their IDs as keys and full path names as values.
     *
     * @param bool $isDefaultOptions Determines whether to include a default option in the array.
     * @return array An array of categories with IDs as keys and full path names as values.
     */
    public function getCategoryArray($isDefaultOptions=true) {
    	$this->db->select('id, name, full_path');
        $this->db->where('status', self::STATUS_ACTIVE);
    	$this->db->order_by('full_path', 'asc');
        $query = $this->db->get($this->table);

        $categories = [];

        if($isDefaultOptions){
            $categories = ['0' => 'Select Parent Category'];            
        }
        
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $categories[$row->id] = $this->getFullPathName($row->id);
            }
        }
        
        return $categories;
    }

    /**
     * Get the slug based on the provided category ID.
     *
     * If the category ID is empty, an empty string is returned.
     *
     * @param int $categoryId The ID of the category
     * @return string The slug corresponding to the category ID, or an empty string if not found
     */
    public function getSlugBasedOnCategoryId($categoryId) {
        if(!$categoryId){
            return '';
        }
		$sql = "SELECT `slug` FROM $this->table WHERE id = ?";
		$query = $this->db->query($sql, array($categoryId));
		$result = $query->row_array();
        return ($result['slug'] ?? '');
    }

    /**
     * Get the category ID based on the provided slug.
     *
     * @param string $slug The slug of the category.
     * @return string The ID of the category corresponding to the given slug, or an empty string if not found.
     */
    public function getCategoryIdBasedOnSlug($slug) {
        if(!$slug){
            return '';
        }
		$sql = "SELECT `id` FROM $this->table WHERE slug = ?  ORDER BY id DESC";
		$query = $this->db->query($sql, array($slug));
		$result = $query->row_array();
        return ($result['id'] ?? '');
    }

 /**
  * Retrieves all categories that have the specified ID in their full_path field.
  *
  * @param int $id The ID to search for in the full_path field
  * @return array An array of categories that match the criteria, or an empty array if no matches are found
  */
	public function getAllCategoriesHavingCurrentId($id){
		if(!$id){
			return [];
		}

	    $this->db->from($this->table);
	    $this->db->where("FIND_IN_SET($id, full_path) > 0");
	    $query = $this->db->get();

	    if ($query->num_rows() > 0) {
	        return $query->result_array();
	    }
	       
	    return [];
	}


 /**
  * Get the full path name of a category based on its category ID.
  *
  * This method recursively fetches the parent categories to construct the full path name.
  *
  * @param int $categoryId The ID of the category
  * @return string The full path name of the category
  */
	public function getFullPathName($categoryId) {
        if (!$categoryId) {
            return '';
        }
        
        $category = $this->db->get_where($this->table, ['id' => $categoryId])->row_array();
        
        if (!$category) {
            return '';
        }
        
        if (!$category['parent_category_id']) {
            return $category['name'];
        }
        
        $parentFullPath = $this->getFullPathName($category['parent_category_id']);
        return $parentFullPath ? $parentFullPath . ' -> ' . $category['name'] : $category['name'];
    }

    /**
     * Get the full path ID of a category by recursively traversing its parent categories.
     *
     * @param int $categoryId The ID of the category
     * @return string The full path ID of the category
     */
    public function getFullPathId($categoryId) {
        if (!$categoryId) {
            return '';
        }
        
        $category = $this->db->get_where($this->table, ['id' => $categoryId])->row_array();
        
        if (!$category) {
            return '';
        }
        
        if (!$category['parent_category_id']) {
            return $category['id'];
        }
        
        $parentFullPath = $this->getFullPathId($category['parent_category_id']);
        return $parentFullPath ? $parentFullPath . ',' . $category['id'] : $category['id'];
    }

    /**
     * Update the full path of categories based on the provided category ID.
     *
     * @param int $categoryId
     * @return $this
     */
    public function updateCategoryFullPath($categoryId){
    	if(!$categoryId){
    		return $this;
    	}

    	$allCategoriesHavingCurrentId = $this->getAllCategoriesHavingCurrentId($categoryId);

    	if(!empty($allCategoriesHavingCurrentId)){
    		foreach ($allCategoriesHavingCurrentId as $category) {
    			$id = isset($category['id']) ? $category['id'] : 0;
    			if(!$id){
    				continue;
    			}

    			$data['full_path'] = $this->getFullPathId($id);
    			$this->Categories_model->edit($data, $id);
    		}
    	}

    	return $this;
    }

    public function getChildCategories($categoryId) {
        return $this->db->get_where($this->table, ['parent_category_id' => $categoryId])->result_array();
    }

    /**
     * Get an array of categories excluding subcategories for a given category ID.
     *
     * This method queries the database to retrieve categories that do not have the given category ID in their full path.
     * It then constructs an array with category IDs as keys and full path names as values.
     *
     * @param int $categoryId The ID of the category to exclude subcategories from
     * @return array An array of categories with IDs as keys and full path names as values
     */
    public function getCategoryArrayExceptSub($categoryId){
    	$this->db->select('id, name, full_path');
    	$this->db->where("FIND_IN_SET($categoryId, full_path) = 0");
    	$this->db->order_by('full_path', 'asc');
        $query = $this->db->get($this->table);
        
        $categories = ['0' => 'Select Parent Category'];
        
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $categories[$row->id] = $this->getFullPathName($row->id);
            }
        }
        
        return $categories;
    }

    
    /**
     * Retrieves categories with a high number of associated products from the database.
     * 
     * This method constructs a SQL query to select categories along with the count of products in each category.
     * It then joins the 'categories' table with the 'products' table based on the category_id foreign key.
     * The result is grouped by category ID and ordered by the product count in descending order.
     * Finally, it limits the result set to the top 4 categories with the highest product counts.
     * 
     * @return array An array of category data with the product count for each category.
     */
    public function getCategoriesWithManyProducts() {
        $this->db->select('categories.*, COUNT(products.id) as product_count');
        $this->db->from('categories');
        $this->db->join('products', 'categories.id = products.category_id', 'left');
        $this->db->group_by('categories.id');
        //$this->db->order_by('categories.name', 'asc');
        $this->db->order_by('product_count', 'DESC');
        $this->db->limit(4);
        return $this->db->get()->result_array();
    }

   
    public function get_categories_recursive($parent_id = 0) {
        $this->db->select('categories.id, categories.parent_category_id, categories.name, COUNT(products.id) as product_count');
        $this->db->from($this->table);
        $this->db->join('products', 'categories.id = products.category_id', 'left');
        $this->db->group_by('categories.id');
        $this->db->where('categories.parent_category_id', $parent_id);
        $query = $this->db->get();
        $result = $query->result_array();

        $categories = [];

        foreach ($result as $key => $value) {
            $categories[$key] = $value;
            $sub_categories = $this->get_categories_recursive($value['id']);
            if (!empty($sub_categories)) {
                $categories[$key]['sub_category'] = $sub_categories;

            }

            if (empty($sub_categories)) {
                $categories[$key]['sub_category'] = [];

            }
        }

        return $categories;
    }   
}
