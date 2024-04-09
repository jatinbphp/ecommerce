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

    public function contactPage() {
        $this->frontRenderTemplate('front/Contact/contactUs');
    }

}