<?php 

class Product_model extends CI_Model
{   
    public $table = "products";
    public $select_column = ['*'];
    public $order_column = ['id', 'product_name', 'sku', 'price', 'status', 'created_at'];

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

	public function create($data = ''){
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

    public function getLatestProducts(){
        $this->db->select('products.*, product_images.image as image');
        $this->db->from($this->table);
        $this->db->join('product_images', 'products.id = product_images.product_id', 'left');
        $this->db->where('products.status', self::STATUS_ACTIVE);
        $this->db->order_by('products.created_at', 'DESC');
        $this->db->limit(8);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getFilteredProducts($categoryId=0){
        $this->db->select('products.*, product_images.image as image');
        $this->db->from($this->table);
        $this->db->join('product_images', 'products.id = product_images.product_id', 'left');
        $this->db->where('products.status', self::STATUS_ACTIVE);

        if ($categoryId) {
            $this->db->where('products.category_id', $categoryId);
        }

        $this->db->limit(8);
        $query = $this->db->get();
        return $query->result_array();
    }
}
