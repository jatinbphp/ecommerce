<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BannerController extends MY_Controller
{
	protected $_data = [];
	public function __construct(){
		parent::__construct();
		$this->checkAdminLoggedIn();
		$this->data['page_title'] = 'Banners';
		$this->load->model('Banner_model');
	}

	public function index(){
		$this->adminRenderTemplate('admin/Banner/index');
	}

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
			'image' => $this->uploadAndgetPath(),
		];

		$create = $this->Banner_model->create($data);
	
		if($create == true) {
			$this->session->set_flashdata('success', 'Successfully created.');
			redirect('admin/banners', 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Error occurred!!');
			redirect('admin/banners/create', 'refresh');
		}
	}

	public function validate_image($image) {
	    if (empty($_FILES['image']['name'])) {
	        $this->form_validation->set_message('validate_image', 'The {field} field is required.');
	        return false;
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

	        $config['upload_path'] = 'uploads/banners/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = 106610;
			$config['encrypt_name'] = TRUE; // Change to TRUE for security reasons

	        $this->upload->initialize($config);

	        if ($this->upload->do_upload('image')) {
	            $uploadData = $this->upload->data();
	            $imagePath = 'uploads/banners/' . $uploadData['file_name'];

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

				if($path = $this->uploadAndgetPath()){
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
					$this->session->set_flashdata('success', 'Successfully updated.');
					redirect('admin/banners', 'refresh');
				} else {
					$this->session->set_flashdata('error', 'Error occurred!!');
					redirect('admin/banners/edit/'.$id, 'refresh');
				}
			} else {
				$bannerData = $this->Banner_model->getDetails($id);
				$this->data['banner_data'] = $bannerData;
				$this->data['status'] = $this->Banner_model::$status;
				$this->adminRenderTemplate('admin/Banner/edit', $this->data);
			}
		}
	}

	public function delete($id)
	{
		if($id) {
			$data = [
				'deleted' => 1
			];
			$bannerDataRow = $this->Banner_model->getDetails($id);
			if(isset($bannerDataRow['image'])){
				if (file_exists($bannerDataRow['image'])) {
					unlink($bannerDataRow['image']);
				}
			}
			$delete = $this->Banner_model->delete($id);
			if($delete == true) {
				$this->session->set_flashdata('success', 'Successfully Deleted');
				redirect('admin/banners', 'refresh');
			}
			else {
				$this->session->set_flashdata('error', 'Error occurred!!');
				redirect('admin/banners', 'refresh');
			}

		}
	}

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

	public function show($id){
        $banner = $this->Banner_model->getDetails($id);
       	$data['banner'] = $banner;
        $html = $this->load->view('admin/Banner/view', $data, true);
        echo $html;
    }
}