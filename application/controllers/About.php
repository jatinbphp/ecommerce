<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {

    public function index() {
        $this->load->helper('url'); // Load the URL Helper
        $this->load->view('about'); 
    }

    public function home() {
        $this->load->helper('url'); 
        $this->load->view('home');
    }
    
    public function contact_us() {
        $this->load->helper('url'); 
        $this->load->view('contact-us');
    }
}