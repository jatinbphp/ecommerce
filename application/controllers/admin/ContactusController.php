<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ContactusController extends MY_Controller
{
	public function __construct(){
		parent::__construct();
		$this->checkAdminLoggedIn();
		$this->data['page_title'] = 'Contact Us';
		$this->load->model('Contactus_model');
	}

	public function index(){
		$this->adminRenderTemplate('admin/ContactUs/index');
	}

	public function fetchContactUs()
	{
		$data    = [];
		$allData = $this->Contactus_model->make_datatables();

		foreach ($allData as $row) {
			$contactusData = [];
			$contactusData[] = "#".$row->id;
			$contactusData[] = $row->name;
			$contactusData[] = $row->email;
			$contactusData[] = $row->message;
			$contactusData[] = $row->created_at;
			$contactusData[] = '<a href="javascript:void(0);" class="btn btn-sm btn-danger deleteRecord" style="margin-right:5px;" data-id="' . $row->id . '" data-controller="contact-us" data-title="ContactUs"><i class="fa fa-trash"></i></a><a href="javascript:void(0)" title="View Contact Us" data-id="'. $row->id .'" class="btn btn-sm btn-warning tip  view-info" data-title="Contact Us Details" data-url="'.base_url('admin/contact-us/show/' . $row->id).'">
            	<i class="fa fa-eye"></i></a>';

			$data[] = $contactusData;
		}

		$output = [
			"draw"            => intval($_POST["draw"]),
			"recordsTotal"    => $this->Contactus_model->get_all_data(),
			"recordsFiltered" => $this->Contactus_model->get_filtered_data(),
			"data"            => $data,
		];
		echo json_encode($output);
	}

	public function delete($id)
	{
		if($id) {
			$data = [
				'deleted' => 1
			];

			$delete = $this->Contactus_model->delete($id);
			if($delete == true) {
				$this->session->set_flashdata('success', 'Contactus has been deleted successfully!');
				redirect('admin/contact-us', 'refresh');
			}
			else {
				$this->session->set_flashdata('error', 'Error occurred!!');
				redirect('admin/contact-us', 'refresh');
			}

		}
	}

	public function show($id){
        $contactus = $this->Contactus_model->getDetails($id);
       	$data['contactus'] = $contactus;
        $html = $this->load->view('admin/ContactUs/view', $data, true);
        echo $html;
    }
}