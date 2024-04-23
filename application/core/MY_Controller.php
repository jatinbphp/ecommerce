<?php

class MY_Controller extends CI_Controller 
{
	public function __construct() {
        parent::__construct();
    }

	public function frontRenderTemplate($page = null, $data = array())
	{   

        $data['footer_data'] = $this->getFooterData();
		$this->load->view('front/Layout/header',$data);
		$this->load->view($page, $data);
		$this->load->view('front/Layout/footer',$data);
        $this->load->view('front/Layout/models',$data);
	}

    public function getFooterData(){
        $this->load->model('Settings_model');
        $this->load->model('Categories_model');
        $settingsData = $this->Settings_model->getSettingsById(1);
        
        if ($settingsData) {
            $footerMenuCategoriesIds = explode(',', $settingsData['footer_menu_categories']);
            $footerMenuCategoriesNames = [];
            foreach ($footerMenuCategoriesIds as $categoryId) {
                $categoryData = $this->Categories_model->getDetails($categoryId);
                if ($categoryData) {
                    $footerMenuCategoriesNames[] = $this->Categories_model->getFullPathName($categoryId);
                }
            }
    
            $headerMenuCategoriesIds = explode(',', $settingsData['header_menu_categories']);
            $headerMenuCategoriesNames = [];
            foreach ($headerMenuCategoriesIds as $categoryId) {
                $headerCategoryData = $this->Categories_model->getDetails($categoryId);
                if ($headerCategoryData) {
                    $headerMenuCategoriesNames[] = $this->Categories_model->getFullPathName($categoryId);
                }
            }
            return [
                'headerMenuCategoriesNames' => $headerMenuCategoriesNames,
                'settingsData' => $settingsData,
                'footerMenuCategoriesNames' => $footerMenuCategoriesNames
            ];
        }
        return [];
    }

	public function adminRenderTemplate($page = null, $data = array())
	{
        $this->checkAdminLoggedIn();
		$this->load->view('admin/Layout/header',$data);
		$this->load->view($page, $data);
        $this->load->view('admin/Layout/models',$data);
		$this->load->view('admin/Layout/footer',$data);
	}

	public function adminRedirect() {
        $CI =& get_instance();
        if ($CI->session->userdata('admin_logged_in')) {
            redirect('admin/dashboard');
            exit;
        }
    }

	public function userRedirectIfLoggedIn() {
        $CI =& get_instance();
        if ($CI->session->userdata('logged_in')) {
            redirect(base_url());
            exit;
        }
    }

    public function checkUserLoggedIn() {
        $CI =& get_instance();
        if (!$CI->session->userdata('logged_in')) {
            redirect('signIn'); 
        }
    }
    
    public function userRedirectIfOtpNotSent(){

        $CI =& get_instance();
        $getSessionVar = $CI->session->userdata('otp_sent');
        if (!isset($getSessionVar)) {
            redirect(base_url());
            exit;
        }
    }

	public function getAdminData($email) {
        $CI =& get_instance();
        $adminData = $CI->user_model->getAdminData($email);
        return $adminData;
    }

	public function checkAdminLoggedIn() {
        $CI =& get_instance();
        if (!$CI->session->userdata('admin_logged_in')) {
            redirect('admin');
            exit;
        }
    }

    public function getStatusButton($id, $status, $tableName){
        if(!$id || !$status || !$tableName){
            return '';
        }
        $button = '';
        if ($status == "active"){
            $button .= 
                '<div class="btn-group-horizontal" id="assign_remove_'.$id.'">
                    <button class = "btn btn-sm btn-success assign_unassign ladda-button" data-style = "slide-left"  data-url = '. base_url("admin/AdminController/updateStatus").' data-id = '.$id.' type = "button" data-type = "unassign" data-table_name = "'.$tableName.'"><span class="ladda-label">Active</span>
                    </button>
                </div>
                <div class="btn-group-horizontal" id="assign_add_'.$id.'" style="display: none">
                    <button class = "btn btn-sm btn-danger assign_unassign ladda-button" data-style = "slide-left"  data-url = '. base_url("admin/AdminController/updateStatus").' data-id = '.$id.' type = "button" data-type = "assign" data-table_name = "'.$tableName.'"><span class="ladda-label">In Active</span>
                    </button>
                </div>';
        } else {
            $button .= 
                '<div class="btn-group-horizontal" id="assign_add_'.$id.'">
                    <button class = "btn btn-sm btn-danger assign_unassign ladda-button" data-style = "slide-left"  data-url = '. base_url("admin/AdminController/updateStatus").' data-id = '.$id.' type = "button" data-type = "assign" data-table_name = "'.$tableName.'"><span class="ladda-label">In Active</span>
                    </button>
                </div>
                <div class="btn-group-horizontal" id="assign_remove_'.$id.'" style="display: none">
                    <button class = "btn btn-sm btn-success assign_unassign ladda-button" data-style = "slide-left"  data-url = '. base_url("admin/AdminController/updateStatus").' data-id = '.$id.' type = "button" data-type = "unassign" data-table_name = "'.$tableName.'"><span class="ladda-label">Active</span>
                    </button>
                </div>';
        }
        return $button;
    }

    // public function addToGuestCart()
    // {
    //     //$this->session->unset_userdata('guestCart');
    //     $cart = $this->session->userdata('guestCart');
        
    //     if ($cart) {
    //         $cart[] = $guestCartData;
    //     } else {
    //         $cart = array($guestCartData);
    //     }

    //     $this->session->set_userdata('guestCart', $cart);

    //     if ($this->session->has_userdata('guestCart')) {
    //         $guestCart = $this->session->userdata('guestCart');
    //         $cartCounter = count($guestCart);
    //     }
    //     else
    //     {
    //         //
    //     }
    // }
}
