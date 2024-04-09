<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ContentManagementController extends MY_Controller {
	protected $_data = [];

	public function __construct(){
		parent::__construct();
		$this->checkAdminLoggedIn();
		$this->data['page_title'] = 'Content Management';
		$this->load->model('Content_model');
	}

	public function index(){
        $this->adminRenderTemplate('admin/ContentManagement/index');		
	}

	public function edit($id = null){
		if($id) {
			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('description', 'Description', 'required');

			if($this->form_validation->run()){
				$data = [
					'title' => $this->input->post('title'),
					'description' => $this->input->post('description'),
				];

				$update = $this->Content_model->edit($data, $id);
				if($update == true) {
					$this->session->set_flashdata('success', 'Content has been updated successfully!');
					redirect('admin/contemt-management', 'refresh');
				} else {
					$this->session->set_flashdata('error', 'Error occurred!!');
					redirect('admin/contemt-management/edit/'.$id, 'refresh');
				}
			} else {
				$bannerData = $this->Content_model->getDetails($id);
				$this->data['content_data'] = $bannerData;
				$this->adminRenderTemplate('admin/ContentManagement/edit', $this->data);
			}
		}
	}

	public function fetchContent(){
		$data    = [];
		$allData = $this->Content_model->make_datatables();

		foreach ($allData as $row) {
			$contentData = [];
			$contentData[] = "#".$row->id;
			$contentData[] = html_entity_decode($row->title);
			$contentData[] = '<a href="' . base_url('admin/contemt-management/edit/' . $row->id) . '" class="btn btn-sm btn-info"  style="margin-right:5px;"><i class="fa fa-edit"></i></a><a href="javascript:void(0)" title="View Content" data-id="'. $row->id .'" class="btn btn-sm btn-warning tip  view-info" data-title="Content Details" data-url="'.base_url('admin/contemt-management/show/' . $row->id).'">
            	<i class="fa fa-eye"></i></a>';

			$data[] = $contentData;
		}

		$output = [
			"draw"            => intval($_POST["draw"]),
			"recordsTotal"    => $this->Content_model->get_all_data(),
			"recordsFiltered" => $this->Content_model->get_filtered_data(),
			"data"            => $data,
		];
		echo json_encode($output);
	}

	public function show($id){
        $content = $this->Content_model->getDetails($id);
       	$data['content'] = $content;
        $html = $this->load->view('admin/ContentManagement/view', $data, true);
        echo $html;
    }
}