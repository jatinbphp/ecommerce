<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CategoriesController extends MY_Controller
{
	public function __construct(){
		parent::__construct();
		$this->checkAdminLoggedIn();
		$this->data['page_title'] = 'Categories';
		$this->load->model('Categories_model');
	}

	public function index(){
		$this->adminRenderTemplate('admin/Categories/index', $this->data);
	}

	public function create(){
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_rules('image', 'Image', 'callback_validate_image');

        if ($this->form_validation->run() == FALSE) {
        	$this->data['allCategories'] = $this->Categories_model->getCategoryArray();
        	$this->data['status'] = $this->Categories_model::$status;
        	$this->adminRenderTemplate('admin/Categories/create', $this->data);
        	return $this;
        }

		$data = [
			'name' => $this->input->post('name'),
			'status' => $this->input->post('status'),
			'image' => $this->uploadAndgetPath(),
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

	public function validate_image($image) {
	    if (empty($_FILES['image']['name'])) {
	        $this->form_validation->set_message('validate_image', 'The {field} field is required.');
	        return true;
	    } else {
	        $allowed_types = ['jpeg', 'jpg', 'png'];
	        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
	        if (!in_array(strtolower($ext), $allowed_types)) {
	            $this->form_validation->set_message('validate_image', 'The {field} must be a valid JPEG, JPG, or PNG file.');
	            return false;
	        }
	    }
	    return true;
	}

	public function uploadAndgetPath() {
	    if (!empty($_FILES['image']['name'])) {
	        $this->load->library('upload');

	        $config['upload_path'] = 'uploads/categories/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = 106610;
			$config['encrypt_name'] = TRUE; // Change to TRUE for security reasons

	        $this->upload->initialize($config);

	        if ($this->upload->do_upload('image')) {
	            $uploadData = $this->upload->data();
	            $imagePath = 'uploads/categories/' . $uploadData['file_name'];

	            return $imagePath;
	        } else {
	        	//echo $this->upload->display_errors();
	        	//return $this->upload->display_errors();
	            return '';
	        }
	    } else {
	        return '';
	    }
	}

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

				if($path = $this->uploadAndgetPath()){
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
				$this->data['category_data'] = $categories_data;
				$this->data['allCategories'] = $this->Categories_model->getCategoryArrayExceptSub($id);
        		$this->data['status'] = $this->Categories_model::$status;
				$this->adminRenderTemplate('admin/Categories/edit', $this->data);
			}
		}
	}

	public function delete($id)
	{
		if($id) {

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
			if($delete == true) {
				$this->session->set_flashdata('success', 'Category has been deleted successfully!');
				redirect('admin/categories', 'refresh');
			}
			else {
				$this->session->set_flashdata('error', 'Error occurred!!');
				redirect('admin/categories', 'refresh');
			}

		}
	}

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

	public function show($id){
        $categoryData = $this->Categories_model->getDetails($id);
        $categoryData['path'] = $this->Categories_model->getFullPathName($id);
       	$data['categoryData'] = $categoryData;
        $html = $this->load->view('admin/Categories/view', $data, true);
        echo $html;
    }
}