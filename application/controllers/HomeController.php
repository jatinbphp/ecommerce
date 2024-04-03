<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends MY_Controller {

	 public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->frontRenderTemplate('front/Home/homePage');
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