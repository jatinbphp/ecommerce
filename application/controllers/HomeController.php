<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Banner_model');
    }

    public function index() {
        $data['banner_data'] = $this->Banner_model->getActiveBammerData();
        $this->frontRenderTemplate('front/Home/homePage', $data);
    }

    public function aboutUs() {
        $this->frontRenderTemplate('front/About/aboutUs');
    }

    public function shopPage() {
        $this->frontRenderTemplate('front/Shop/shop');
    }
    
    public function termaConditions() {
        $sql = "SELECT * FROM content_management WHERE id = 2";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        $this->frontRenderTemplate('front/TermsConditions/termaConditionsPage',['terms_data' => $data]);
    }

    public function privecyPolicy() {
        $sql = "SELECT * FROM content_management WHERE id = 1";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        $this->frontRenderTemplate('front/PrivecyPolicy/privecyPolicyPage',['privecy_data' => $data]);
    }

}