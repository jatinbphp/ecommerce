<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SettingsController extends MY_Controller
{
	protected $_data = [];

	public function __construct(){
		parent::__construct();
		$this->checkAdminLoggedIn();
		$this->data['page_title'] = 'Settings';
		$this->load->model('Settings_model');
	}

	public function edit()
    {
        $this->load->model('Categories_model');

        $settings_data = $this->Settings_model->getSettingsById(1);
        $categories_data = $this->Categories_model->getCategoryArray(false);

        $selected_header_categories = [];
        $selected_footer_categories = [];

        if (isset($settings_data['header_menu_categories']) && $settings_data['header_menu_categories'] !== null) {
            $selected_header_categories = explode(',', $settings_data['header_menu_categories']);
        }

        if (isset($settings_data['footer_menu_categories']) && $settings_data['footer_menu_categories'] !== null) {
            $selected_footer_categories = explode(',', $settings_data['footer_menu_categories']);
        }
            
        $this->data['categories_data'] = $categories_data;
        $this->data['settings_data'] = $settings_data;
        $this->data['selected_header_categories'] = $selected_header_categories;
        $this->data['selected_footer_categories'] = $selected_footer_categories;

        $this->adminRenderTemplate('admin/Setting/edit', $this->data);
        return $this;
    }

    public function update()
    {
        $data = [
			'email_address' => $this->input->post('email_address'),
			'phone_number' => $this->input->post('phone_number'),
            'address' => $this->input->post('address'),
            'facebook_url' => $this->input->post('facebook_url'),
            'youtube_url' => $this->input->post('youtube_url'),
            'instagram_url' => $this->input->post('instagram_url'),
            'linkedin_url' => $this->input->post('linkedin_url'),
		];

        if(!empty($this->input->post('header_menu_categories')))
        {
            $data['header_menu_categories']= implode(',', $this->input->post('header_menu_categories'));
        }

        if(!empty($this->input->post('footer_menu_categories')))
        {
            $data['footer_menu_categories']= implode(',', $this->input->post('footer_menu_categories'));
        }

        $this->Settings_model->update(1, $data);
		
        $this->session->set_flashdata('success', 'Settings successfully updated.');

		redirect('admin/settings/edit', 'refresh');
    }
}
