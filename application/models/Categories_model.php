<?php 

class Categories_model extends CI_Model
{   
    public $table = "categories";
    public $select_column = ['*'];
    public $order_column = ['id', 'name', 'status', 'created_at'];
    protected $_categoryIdWiseName = [];

	public function __construct(){
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

	public function create($data = []){
		if($data) {
			$create = $this->db->insert($this->table, $data);
			if ($create) {
	            return $this->db->insert_id();
	        } else {
	            return 0;
	        }
		}
		return 0;
	}

	public function edit($data = array(), $id = null){
		$this->db->where('id', $id);
		$update = $this->db->update($this->table, $data);
		return ($update == true) ? true : false;	
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete($this->table);
		return ($delete == true) ? true : false;
	}

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

    public function make_datatables()
    {
        $this->make_query();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();

        return $query->result();
    }

    public function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_data()
    {
        $this->db->select("*");
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function getCategoryArray($isDefaultOptions=true) {
    	$this->db->select('id, name, full_path');
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

    /*get categories which has may products*/
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
}
