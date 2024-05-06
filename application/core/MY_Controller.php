<?php

class MY_Controller extends CI_Controller 
{
 /**
  * Constructor for the class.
  */
	public function __construct() {
        parent::__construct();
    }

 /**
  * Renders the front-end template with header, specified page content, footer, and models.
  *
  * @param string|null $page
  * @param array $data
  * @return void
  */
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

    /**
     * Retrieves footer data including header and footer menu categories names and settings data.
     *
     * Loads the Settings_model and Categories_model to fetch necessary data.
     * Parses the footer menu categories and header menu categories from the settings data.
     * Retrieves category details and full path names using Categories_model.
     *
     * @return array
     */
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

    /**
     * Render an admin template with header, specified page content, models, and footer.
    *
    * @param string|null $page The page content to render.
    * @param array $data Additional data to pass to the views.
    * @throws AdminNotLoggedInException If the admin is not logged in.
    */
	public function adminRenderTemplate($page = null, $data = array())
	{
        $this->checkAdminLoggedIn();
		$this->load->view('admin/Layout/header',$data);
		$this->load->view($page, $data);
        $this->load->view('admin/Layout/models',$data);
		$this->load->view('admin/Layout/footer',$data);
	}

    /**
     * Redirects the user to the admin dashboard if the user is logged in as an admin.
    */
	public function adminRedirect() {
        $CI =& get_instance();
        if ($CI->session->userdata('admin_logged_in')) {
            redirect('admin/dashboard');
            exit;
        }
    }

    /**
     * Redirect the user to the base URL if they are already logged in.
    */
	public function userRedirectIfLoggedIn() {
        $CI =& get_instance();
        if ($CI->session->userdata('logged_in')) {
            redirect(base_url());
            exit;
        }
    }

    /**
     * Checks if a user is logged in. If not, redirects to the sign-in page.
     */
    public function checkUserLoggedIn() {
        $CI =& get_instance();
        if (!$CI->session->userdata('logged_in')) {
            redirect('signIn'); 
        }
    }
    
    /**
     * Redirect the user to the base URL if OTP has not been sent.
     * 
     * This function checks if the 'otp_sent' session variable is set. If it is not set, the user is redirected to the base URL.
     */
    public function userRedirectIfOtpNotSent(){

        $CI =& get_instance();
        $getSessionVar = $CI->session->userdata('otp_sent');
        if (!isset($getSessionVar)) {
            redirect(base_url());
            exit;
        }
    }

    /**
     * Retrieves the admin data for the given email address.
    *
    * @param string $email The email address of the admin
    * @return mixed The admin data retrieved from the user model
    */
	public function getAdminData($email) {
        $CI =& get_instance();
        $adminData = $CI->user_model->getAdminData($email);
        return $adminData;
    }

    /**
     * Checks if the admin is logged in. If not, redirects to the admin login page.
    */
	public function checkAdminLoggedIn() {
        $CI =& get_instance();
        if (!$CI->session->userdata('admin_logged_in')) {
            redirect('admin');
            exit;
        }
    }

    /**
     * Generates a status button based on the provided parameters.
     *
     * @param int $id The ID of the item
     * @param string $status The status of the item (active or inactive)
     * @param string $tableName The name of the table
     * @return string The HTML code for the status button
     */
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

    /**
     * Uploads a file to the specified target directory.
     *
     * @param string $targetDirectory The directory where the file will be uploaded.
     * @param array $file The file data to be uploaded.
     * @return string The path to the uploaded file, or an empty string if upload fails.
     */
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

        if(!in_array($imageFileType, ["jpg", "png", "jpeg", "gif", 'webp', 'avif'])) {
            return '';
        }

        if($isUpload){
            if (move_uploaded_file($file["image"]["tmp_name"], $targetFile)) {
                return $targetFile;
            }
        }
        return '';
    }

    /**
     * Uploads multiple files to the specified target directory.
     *
     * @param string $targetDirectory The directory where the files will be uploaded.
     * @param array $files An array containing the files to be uploaded.
     * @return array An array of the successfully uploaded file paths.
     */
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
    
            if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif", "webp", 'avif'])) {
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
