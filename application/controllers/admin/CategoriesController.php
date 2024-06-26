<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* This class extends the MY_Controller class and likely contains methods and properties specific to
Categories tasks. */
class CategoriesController extends MY_Controller
{
	/**
	 * The constructor function initializes the Categories page with necessary data and checks if the
	 * admin is logged in.
	 */
	public function __construct(){
		parent::__construct();
		$this->checkAdminLoggedIn();
		$this->data['page_title'] = 'Categories';
		$this->data['form_title'] = 'Category';
		$this->load->model('Categories_model');
	}

	/**
	 * The index function renders the admin template for displaying categories with the provided data.
	 */
	public function index(){
		$this->adminRenderTemplate('admin/Categories/index', $this->data);
	}

	/**
	 * The function `create` handles form validation, data processing, and database insertion for
	 * creating categories in an admin panel.
	 * 
	 * @return In the `create()` function, if the form validation fails, the function returns the current
	 * object instance using `return ;`. This allows for method chaining or further operations to be
	 * performed on the object after the `create()` function is called.
	 */
	public function create(){
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_rules('image', 'Image', 'callback_validate_image');

        if ($this->form_validation->run() == FALSE) {
        	/**
			 * The above PHP function is a constructor that checks if an admin is logged in, sets page and form
			 * titles for categories, and loads the Categories_model.
			 */
			$this->data['allCategories'] = $this->Categories_model->getCategoryArray();
        	$this->data['status'] = $this->Categories_model::$status;
        	$this->adminRenderTemplate('admin/Categories/create', $this->data);
        	return $this;
        }

		$data = [
			'name' => $this->input->post('name'),
			'status' => $this->input->post('status'),
			'image' => $this->uploadFile('uploads/categories', $_FILES),
		];

		if(!empty($this->input->post('parent_category_id'))){
			$data['parent_category_id'] = $this->input->post('parent_category_id');
		} else {
			$data['parent_category_id'] = 0;
		}

		$createId = $this->Categories_model->create($data);
	
		if($createId){
			if(!empty($this->input->post('parent_category_id'))){
				$categoryData = $this->Categories_model->getDetails($this->input->post('parent_category_id'));
				if($categoryData && isset($categoryData['full_path'])){
					$parantPath = explode(',', $categoryData['full_path']);
					$parantPath[] = $createId;
					$this->Categories_model->edit(['full_path' => implode(',', $parantPath)], $createId); 
				}
			} else {
				$parantPath[] = $createId;
				$this->Categories_model->edit(['full_path' => implode(',', $parantPath)], $createId);
			}
			$this->session->set_flashdata('success', 'Category has been inserted successfully!');
			redirect('admin/categories', 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Error occurred!!');
			redirect('admin/categories/create', 'refresh');
		}
	}

	/**
	 * The function `validate_image` checks if the uploaded image file is empty or has a valid JPEG, JPG,
	 * or PNG extension.
	 * 
	 * @param image The `validate_image` function is function that is used to validate an image file
	 * uploaded through a form. It checks if the image file meets certain criteria before allowing it to
	 * be processed further.
	 * 
	 * @return The function `validate_image` returns a boolean value. It returns `true` if the image field
	 * is empty or if the image file has a valid extension (JPEG, JPG, or PNG). It returns `false` if the
	 * image file has an invalid extension.
	 */
	public function validate_image($image) {
	    if (empty($_FILES['image']['name'])) {
	        $this->form_validation->set_message('validate_image', 'The {field} field is required.');
	        return true;
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
	 * The function `edit` is used to update a category's details, including name, status, parent
	 * category, and image, with validation and error handling.
	 * 
	 * @param id The `edit` function you provided is a part of a PHP code snippet. It seems to be a method
	 * within a controller class that handles the editing of a category. The function takes an optional
	 * parameter ``, which is used to identify the category being edited.
	 */
	public function edit($id = null){
		if($id) {
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');
			if($this->form_validation->run() == TRUE){
				$data = [
					'name' => $this->input->post('name'),
					'status' => $this->input->post('status'),
				];

				if(!empty($this->input->post('parent_category_id'))){
					$parentCategoryId = $this->input->post('parent_category_id');
					$data['parent_category_id'] = $parentCategoryId;
				} else {
					$data['parent_category_id'] = 0;
				}

				if($path = $this->uploadFile('uploads/categories', $_FILES)){
					$data['image'] = $path;
					$categoryRow = $this->Categories_model->getDetails($id);
					if(isset($categoryRow['image'])){
						if (file_exists($categoryRow['image'])) {
							unlink($categoryRow['image']);
						}
					}
				}

				$update = $this->Categories_model->edit($data, $id);
				if($update == true) {
					$this->Categories_model->updateCategoryFullPath($id);
					$this->session->set_flashdata('success', 'Category has been updated successfully!');
					redirect('admin/categories', 'refresh');
				} else {
					$this->session->set_flashdata('error', 'Error occurred!!');
					redirect('admin/categories/edit/'.$id, 'refresh');
				}
			} else {
				$categories_data = $this->Categories_model->getDetails($id);
				if(empty($categories_data)){
					redirect('admin/404', 'refresh');
				}
				$this->data['category_data'] = $categories_data;
				$this->data['allCategories'] = $this->Categories_model->getCategoryArrayExceptSub($id);
        		$this->data['status'] = $this->Categories_model::$status;
				$this->adminRenderTemplate('admin/Categories/edit', $this->data);
			}
		}
	}

	/**
	 * The function deletes a category and its child categories, updates parent category IDs, deletes
	 * associated image files, and redirects with success or error messages.
	 * 
	 * @param id The code you provided is a PHP function for deleting a category. The function takes an
	 * `` parameter which is used to identify the category to be deleted.
	 */
	public function delete($id)
	{
		if($id) {

			if ($this->isCategoryAssociatedWithProducts($id)) {
				$data['success'] = 0;
				$data['message'] = "Cannot remove category. It is associated with products.";
				header('Content-Type: application/json');
				echo json_encode($data);
				return $this;
			}

			$categoryDataRow = $this->Categories_model->getDetails($id);
			if(isset($categoryDataRow['image'])){
				if (file_exists($categoryDataRow['image'])) {
					unlink($categoryDataRow['image']);
				}
			}

			$childCategories = $this->Categories_model->getChildCategories($id);
			$removeCategoryData = $this->Categories_model->getDetails($id);

	        foreach ($childCategories as $childCategory) {
	        	if(isset($removeCategoryData['parent_category_id'])){
	        		$this->db->where('id', $childCategory['id']);
		            $this->db->update('categories', ['parent_category_id' => $removeCategoryData['parent_category_id']]);
	        	}
	        }

			$delete = $this->Categories_model->delete($id);
			$this->Categories_model->updateCategoryFullPath($id);
			echo 1;
		}
	}

	public function isCategoryAssociatedWithProducts($categoryId) {
        $this->db->where('category_id', $categoryId);
        $query = $this->db->get('products');
        return $query->num_rows() > 0;
    }

	/**
	 * The fetchCategories function retrieves category data and formats it for display in a DataTable.
	 */
	public function fetchCategories()
	{
		$data    = [];
		$allData = $this->Categories_model->make_datatables();

		foreach ($allData as $row) {
			$categoryData = [];
			$categoryData[] = "#".$row->id;
			$categoryData[] = $this->Categories_model->getFullPathName($row->id);
			$categoryData[] = $this->getStatusButton($row->id, $row->status, 'categories');
			$categoryData[] = $row->created_at;
			$categoryData[] = '<a href="' . base_url('admin/categories/edit/' . $row->id) . '" class="btn btn-sm btn-info"  style="margin-right:5px;"><i class="fa fa-edit"></i></a><a href="javascript:void(0);" class="btn btn-sm btn-danger deleteRecord" style="margin-right:5px;" data-id="' . $row->id . '" data-controller="categories" data-title="Categories"><i class="fa fa-trash"></i></a><a href="javascript:void(0)" title="View Category" data-id="'. $row->id .'" class="btn btn-sm btn-warning tip  view-info" data-title="Category Details" data-url="'.base_url('admin/categories/show/' . $row->id).'">
            	<i class="fa fa-eye"></i></a>';

			$data[] = $categoryData;
		}

		$output = [
			"draw"            => intval($_POST["draw"]),
			"recordsTotal"    => $this->Categories_model->get_all_data(),
			"recordsFiltered" => $this->Categories_model->get_filtered_data(),
			"data"            => $data,
		];
		echo json_encode($output);
	}

	/**
	 * The function "show" retrieves category details and path, then loads and displays the corresponding
	 * view template in PHP.
	 * 
	 * @param id The `show` function in the code snippet is responsible for displaying details of a
	 * category with the given ID. The function retrieves category details and its full path name using
	 * methods from the `Categories_model`. It then loads a view file named `view` located in the
	 * `admin/Categories` directory,
	 */
	public function show($id){
        $categoryData = $this->Categories_model->getDetails($id);
        $categoryData['path'] = $this->Categories_model->getFullPathName($id);
       	$data['categoryData'] = $categoryData;
        $html = $this->load->view('admin/Categories/view', $data, true);
        echo $html;
    }
}