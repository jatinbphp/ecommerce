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

        if ($this->form_validation->run() == FALSE) {
        	$this->adminRenderTemplate('admin/Categories/create', $this->data);
        	return $this;
        }

		$data = [
			'name' => $this->input->post('name'),
		];

		$create = $this->Categories_model->create($data);
	
		if($create == true) {
			$this->session->set_flashdata('success', 'Successfully created.');
			redirect('admin/categories', 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Error occurred!!');
			redirect('admin/categories/create', 'refresh');
		}
	}

	public function edit($id = null){
		if($id) {
			if(!empty($this->input->post('name'))){
				$data = [
					'name' => $this->input->post('name'),
				];

				$update = $this->Categories_model->edit($data, $id);
				if($update == true) {
					$this->session->set_flashdata('success', 'Successfully updated.');
					redirect('admin/categories', 'refresh');
				} else {
					$this->session->set_flashdata('error', 'Error occurred!!');
					redirect('admin/categories/edit/'.$id, 'refresh');
				}
			} else {
				$categories_data = $this->Categories_model->getDetails($id);
				$this->data['categories_data'] = $categories_data;
				$this->adminRenderTemplate('admin/Categories/edit', $this->data);
			}
		}
	}

	public function delete($id)
	{
		if($id) {
			$data = [
				'deleted' => 1
			];
			$delete = $this->Categories_model->delete($id);
			if($delete == true) {
				$this->session->set_flashdata('success', 'Successfully Deleted');
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
			$categoryData[] = $row->name;
			$categoryData[] = $this->getStatusButton($row->id, $row->status, 'categories');
			$categoryData[] = $row->created_at;
			$categoryData[] = '<a href="' . base_url('admin/categories/edit/' . $row->id) . '" class="btn btn-sm btn-warning"  style="margin-right:5px;"><i class="fa fa-edit"></i></a><a href="javascript:void(0);" class="btn btn-sm btn-danger deleteRecord" data-id="' . $row->id . '" data-controller="categories" data-title="Categories"><i class="fa fa-trash"></i></a>';

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
}