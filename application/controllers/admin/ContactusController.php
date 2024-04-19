<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* This class extends the MY_Controller class and likely contains methods and properties specific to
Coontactus tasks. */
class ContactusController extends MY_Controller
{
	/**
	 * The above function constructor that checks if an admin is logged in, sets the page title
	 * to 'Contact Us', and loads a Contactus_model.
	 */
	public function __construct(){
		parent::__construct();
		$this->checkAdminLoggedIn();
		$this->data['page_title'] = 'Contact Us';
		$this->load->model('Contactus_model');
	}

	/**
	 * The index function renders the admin ContactUs index template in PHP.
	 */
	public function index(){
		$this->adminRenderTemplate('admin/ContactUs/index');
	}

	/**
	 * The function fetchContactUs retrieves contact information from the database and formats it for
	 * display in a DataTable.
	 */
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

	/**
	 * The function deletes a contact record based on the provided ID and displays success or error
	 * messages accordingly.
	 * 
	 * @param id The `delete` function in the code snippet is used to delete a contact record based on the
	 * provided ``. The `` parameter represents the unique identifier of the contact record that
	 * needs to be deleted from the database.
	 */
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

	/**
	 * The function "show" retrieves contact details for a specific ID and displays them in a view
	 * template.
	 * 
	 * @param id The `show` function in the code snippet is responsible for displaying the details of a
	 * contact based on the provided ``. The function retrieves the contact details using the
	 * `getDetails` method from the `Contactus_model`, passes the retrieved data to the view file
	 * `admin/ContactUs/view`,
	 */
	public function show($id){
        $contactus = $this->Contactus_model->getDetails($id);
       	$data['contactus'] = $contactus;
        $html = $this->load->view('admin/ContactUs/view', $data, true);
        echo $html;
    }
}