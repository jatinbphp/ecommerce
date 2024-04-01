<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends MY_Controller {

    public function index() {
        $this->render_template('front/Home/homePage');
        // $this->load->view('front/Layout/app'); 
    }
}