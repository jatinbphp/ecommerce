<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* This class extends the MY_Controller class and likely contains methods and properties specific to
Banners tasks. */

class BannerController extends MY_Controller
{
	protected $_data = [];
	
	/**
	 * The constructor function initializes a page for managing banners, ensuring that an admin is logged in and
	 * setting page and form titles.
	 */
	public function __construct(){
		parent::__construct();
		$this->checkAdminLoggedIn();
		$this->data['page_title'] = 'Banners';
		$this->data['form_title'] = 'Banner';
		$this->load->model('Banner_model');
		$this->load->model('Settings_model');
	}

	/**
	 * The index function renders the admin Banner index template with the provided data.
	 */
	public function index(){
		$settingsData = $this->Settings_model->getSettingsById(1);
		$this->data['allow_banner_value'] = $settingsData['is_allow_auto_move_banners'] ?? 0;
		$this->adminRenderTemplate('admin/Banner/index', $this->data);
	}

	/**
	 * The function creates a new banner by validating input data, uploading an image, and storing the
	 * banner details in the database.
	 * 
	 * @return In the `create()` function, the code is returning `` when the form validation fails.
	 */
	public function create(){
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('subtitle', 'Subtitle', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('image', 'Image', 'callback_validate_image');

        if ($this->form_validation->run() == FALSE) {
        	$this->data['status'] = $this->Banner_model::$status;
        	$this->adminRenderTemplate('admin/Banner/create', $this->data);
        	return $this;
        }

		$data = [
			'title' => $this->input->post('title'),
			'subtitle' => $this->input->post('subtitle'),
			'description' => $this->input->post('description'),
			'status' => $this->input->post('status'),
			'image' => $this->uploadFile('uploads/banners', $_FILES),
		];

		$create = $this->Banner_model->create($data);

		if($create == true) {
			$this->session->set_flashdata('success', 'Banner has been inserted successfully!.');
			redirect('admin/banners', 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Error occurred!!');
			redirect('admin/banners/create', 'refresh');
		}
	}

	/**
	 * The function `validate_image` checks if the uploaded image file is not empty and has a valid JPEG,
	 * JPG, or PNG extension.
	 * 
	 * @param image The `validate_image` function is a method that validates an image file uploaded
	 * through a form. It checks if the image field is empty and if the file extension is one of the
	 * allowed types (JPEG, JPG, or PNG).
	 * 
	 * @return The function `validate_image` returns a boolean value - `true` if the image passes the
	 * validation criteria, and `false` if it fails the validation.
	 */
	public function validate_image($image) {
	    if (empty($_FILES['image']['name'])) {
	        $this->form_validation->set_message('validate_image', 'The {field} field is required.');
	        return false;
	    } else {
	        $allowed_types = ['jpeg', 'jpg', 'png', 'webp'];
	        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
	        if (!in_array(strtolower($ext), $allowed_types)) {
	            $this->form_validation->set_message('validate_image', 'The {field} must be a valid JPEG, JPG, or PNG file.');
	            return false;
	        }
	    }
	    return true;
	}

	/**
	 * The `edit` function in PHP is responsible for updating banner details, including validation, file
	 * upload, and database update.
	 * 
	 * @param id The `edit` function you provided is a part of a PHP code snippet. It seems to be a method
	 * within a class, possibly a controller in a CodeIgniter or similar PHP framework.
	 */
	public function edit($id = null){
		if($id) {
			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('subtitle', 'Subtitle', 'required');
			$this->form_validation->set_rules('description', 'Description', 'required');
			if($this->form_validation->run()){
				$data = [
					'title' => $this->input->post('title'),
					'subtitle' => $this->input->post('subtitle'),
					'description' => $this->input->post('description'),
					'status' => $this->input->post('status'),
				];

				if($path = $this->uploadFile('uploads/banners', $_FILES)){
					$data['image'] = $path;
					$bannerDataRow = $this->Banner_model->getDetails($id);
					if(isset($bannerDataRow['image'])){
						if (file_exists($bannerDataRow['image'])) {
							unlink($bannerDataRow['image']);
						}
					}
				}

				$update = $this->Banner_model->edit($data, $id);
				if($update == true) {
					$this->session->set_flashdata('success', 'Banner has been updated successfully!.');
					redirect('admin/banners', 'refresh');
				} else {
					$this->session->set_flashdata('error', 'Error occurred!!');
					redirect('admin/banners/edit/'.$id, 'refresh');
				}
			} else {
				$bannerData = $this->Banner_model->getDetails($id);
				if(empty($bannerData)){
					redirect('admin/404', 'refresh');
				}
				$this->data['banner_data'] = $bannerData;
				$this->data['status'] = $this->Banner_model::$status;
				$this->adminRenderTemplate('admin/Banner/edit', $this->data);
			}
		}
	}

	/**
	 * The function deletes a banner by its ID, removes its associated image file if it exists, and
	 * redirects to the banners page with success or error messages.
	 * 
	 * @param id The `delete` function you provided is responsible for deleting a banner based on the
	 * given ``. It first retrieves the banner details using the `getDetails` method from the
	 * `Banner_model`, checks if the banner image exists, deletes the image file if it exists, and then
	 * proceeds to delete the
	 */
	public function delete($id)
	{
		if($id) {
			$bannerDataRow = $this->Banner_model->getDetails($id);
			if(isset($bannerDataRow['image'])){
				if (file_exists($bannerDataRow['image'])) {
					unlink($bannerDataRow['image']);
				}
			}
			$delete = $this->Banner_model->delete($id);
			if($delete == true) {
				$this->session->set_flashdata('success', 'Banner has been deleted successfully!');
				redirect('admin/banners', 'refresh');
			}
			else {
				$this->session->set_flashdata('error', 'Error occurred!!');
				redirect('admin/banners', 'refresh');
			}

		}
	}

	/**
	 * The fetchBanners function retrieves banner data from the database and formats it for display in a
	 * DataTable.
	 */
	public function fetchBanners()
	{
		$data    = [];
		$allData = $this->Banner_model->make_datatables();

		foreach ($allData as $row) {
			$bannersData = [];
			$bannersData[] = "#".$row->id;
			$bannersData[] = $row->title;
			$bannersData[] = $row->subtitle;
			$bannersData[] = $this->getStatusButton($row->id, $row->status, 'banners');
			$bannersData[] = $row->created_at;
			$bannersData[] = '<a href="' . base_url('admin/banners/edit/' . $row->id) . '" class="btn btn-sm btn-info"  style="margin-right:5px;"><i class="fa fa-edit"></i></a><a href="javascript:void(0);" class="btn btn-sm btn-danger deleteRecord" style="margin-right:5px;" data-id="' . $row->id . '" data-controller="banners" data-title="banners"><i class="fa fa-trash"></i></a><a href="javascript:void(0)" title="View Banner" data-id="'. $row->id .'" class="btn btn-sm btn-warning tip  view-info" data-title="Banner Details" data-url="'.base_url('admin/banners/show/' . $row->id).'">
            	<i class="fa fa-eye"></i></a>';

			$data[] = $bannersData;
		}

		$output = [
			"draw"            => intval($_POST["draw"]),
			"recordsTotal"    => $this->Banner_model->get_all_data(),
			"recordsFiltered" => $this->Banner_model->get_filtered_data(),
			"data"            => $data,
		];
		echo json_encode($output);
	}

	/**
	 * The function "show" retrieves banner details using the Banner_model and displays them in a view
	 * template.
	 * 
	 * @param id The `show` function in the code snippet is a method that takes an `` parameter. This
	 * parameter is used to fetch details of a banner from the `Banner_model` by calling the `getDetails`
	 * method with the provided ``. The retrieved banner details are then passed to the view
	 */
	public function show($id){
        $banner = $this->Banner_model->getDetails($id);
       	$data['banner'] = $banner;
        $html = $this->load->view('admin/Banner/view', $data, true);
        echo $html;
    }

	/**
	 * Update the banner settings based on the input value.
	*
	* This function retrieves the 'isAllow' value from the input POST data, converts it to a boolean value,
	* and updates the 'is_allow_auto_move_banners' setting in the database using the Settings_model.
	* If the setting value is 'true', it is stored as 1, otherwise as 0.
	*
	* @return void
	*/
	public function updateBannerSettings() {
		$settingValue = $this->input->post('isAllow');
		$data['is_allow_auto_move_banners'] = ($settingValue == 'true'  ? 1 : 0);
		$this->Settings_model->update(1, $data);
		echo 1;
	}
}