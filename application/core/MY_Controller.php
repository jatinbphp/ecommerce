<?php

class MY_Controller extends CI_Controller 
{
	public function __construct() {
        parent::__construct();
    }

	public function frontRenderTemplate($page = null, $data = array())
	{   
        $this->load->model('Wishlist_model');
        $this->load->model('Cart_model');
        $data['wishlistProductId'] = $this->Wishlist_model->getWishlistProductIds();
        $data['usrCartCounter']    = $this->Cart_model->getUserCartCounter();
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
            if($footerMenuCategoriesIds && count($footerMenuCategoriesIds)){
                foreach ($footerMenuCategoriesIds as $categoryId) {
                    if(!$categoryId){
                        continue;
                    }
                    $categoryData = $this->Categories_model->getDetails($categoryId);
                    if ($categoryData) {
                        $footerMenuCategoriesNames[$categoryId] = $this->Categories_model->getFullPathName($categoryId);
                    }
                }
            }
    
            $headerMenuCategoriesIds = explode(',', $settingsData['header_menu_categories']);
            $headerMenuCategoriesNames = [];
            if($headerMenuCategoriesIds && count($headerMenuCategoriesIds)){
                foreach ($headerMenuCategoriesIds as $categoryId) {
                    if(!$categoryId){
                        continue;
                    }
                    $headerCategoryData = $this->Categories_model->getDetails($categoryId);
                    if ($headerCategoryData) {
                        $headerMenuCategoriesNames[$categoryId] = $this->Categories_model->getFullPathName($categoryId);
                    }
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

    public function uploadFile($targetDirectory, $file){
        if(!isset($file['image']['name']) || empty($file['image']['name'])){
            return '';
        }

        $imageFileType = strtolower(pathinfo($file["image"]["name"], PATHINFO_EXTENSION));
        $uniqueFilename = uniqid() . '_' . time() . '.' . $imageFileType;
        $targetFile = $targetDirectory . '/'. $uniqueFilename;

        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        $isUpload = 0;
        $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
        if(!isset($file["image"]["tmp_name"])){
            return '';
        }
        $check = getimagesize($file["image"]["tmp_name"]);
        
        if($check !== false) {
            $isUpload = 1;
        }

        if(!in_array($imageFileType, ["jpg", "png", "jpeg", "gif", 'webp'])) {
            return '';
        }

        if($isUpload){
            if (move_uploaded_file($file["image"]["tmp_name"], $targetFile)) {
                return $targetFile;
            }
        }
        return '';
    }

    public function uploadMultipleFiles($targetDirectory, $files) {
        $uploadedFiles = [];

        if(!isset($files['file']['name'])){
            return [];
        }

        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }
    
        foreach ($files['file']['name'] as $key => $filename) {
            $imageFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $uniqueFilename = uniqid() . '_' . time() . '.' . $imageFileType;
            $targetFile = $targetDirectory . '/' . $uniqueFilename;
    
            $isUpload = 0;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            if(!isset($files['file']['tmp_name'][$key])){
                return [];
            }

            $check = getimagesize($files['file']['tmp_name'][$key]);
            
            if ($check !== false) {
                $isUpload = 1;
            }
    
            if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif", "webp"])) {
                // If file type is not allowed, continue to the next file
                continue;
            }
    
            if ($isUpload) {
                if (move_uploaded_file($files['file']['tmp_name'][$key], $targetFile)) {
                    $uploadedFiles[] = $targetFile;
                }
            }
        }
    
        return $uploadedFiles;
    }
}
