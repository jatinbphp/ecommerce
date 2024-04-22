<?php
class Order_model extends CI_Model
{   
    public $table = "orders";
    public $select_column = '*';
    public $order_column = ['id','user_id','address_id', 'total_amount', 'status', 'delivey_method', 'notes', 'address_info','created_at'];

    public function __construct(){
		  parent::__construct();
	  }
    
      public function make_datatables()
      {
          $this->make_query();
          $limit = isset($_POST["length"]) ? $_POST["length"] : -1;
          $start = isset($_POST["start"]) ? $_POST["start"] : 0;
      
          if ($limit != -1) {
              $this->db->limit($limit, $start);
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
    public function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        $this->db->where('user_id', $this->session->userdata('user_data')->id);
        
        if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
            $this->db->order_by($this->order_column[$_POST['order'][0]['column']], $_POST['order'][0]['dir']);
        } else {
            $this->db->order_by('id', 'DESC');
        }
    }

    public function getOrderById($orderId)
    {
        return $this->db->get_where('orders', ['id' => $orderId])->row();
    }

   
}